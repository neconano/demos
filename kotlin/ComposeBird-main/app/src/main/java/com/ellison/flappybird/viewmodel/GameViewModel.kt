package com.ellison.flappybird.viewmodel

import android.app.Application
import android.os.SystemClock
import android.util.Log
import androidx.compose.ui.unit.dp
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.viewModelScope
import com.ellison.flappybird.initTime
import com.ellison.flappybird.util.DensityUtil
import com.ellison.flappybird.util.LogUtil
import com.ellison.flappybird.model.*
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class GameViewModel(application: Application) : AndroidViewModel(application) {

    companion object {
        const val WORK_DURATION = 2000L
    }

    private val _viewState = MutableStateFlow(ViewState())
    val viewState = _viewState.asStateFlow()
    // 强制显示闪屏指定时间
    fun isDataReady() = SystemClock.uptimeMillis() - initTime > WORK_DURATION

    fun dispatch(action: GameAction,
                 playZoneSize: Pair<Int, Int> = Pair(0, 0),
                 pipeIndex: Int = -1,
                 roadIndex: Int = -1
    ) {
        // 根据实际屏幕尺寸进行初始化
        if (playZoneSize.first > 0 && playZoneSize.second > 0) {
            viewState.value.playZoneSize = playZoneSize
        }
        // 两个管道，遍历index分别是0，1
        if (pipeIndex > -1) {
            viewState.value.targetPipeIndex = pipeIndex
        }
        // 两段路，遍历index分别是0，1
        if (roadIndex > -1) {
            viewState.value.targetRoadIndex = roadIndex
        }
        response(action)
    }

    private fun response(action: GameAction) {
        val state: ViewState = viewState.value
        viewModelScope.launch {
            withContext(Dispatchers.Default) {
                emit(when (action) {
                    // 初始化屏幕尺寸，管道及小鸟宽高
                    GameAction.ScreenSizeDetect -> run {
                        val playZoneHeightInDp = DensityUtil.dxToDp(
                            getApplication<Application>().resources,
                            state.playZoneSize.second
                        )
                        // 重置管道
                        TotalPipeHeight = playZoneHeightInDp.dp
                        HighPipe = TotalPipeHeight * MaxPipeFraction
                        MiddlePipe = TotalPipeHeight * CenterPipeFraction
                        LowPipe = TotalPipeHeight * MinPipeFraction
                        PipeDistance = TotalPipeHeight * PipeDistanceFraction
                        val newPipeStateList: List<PipeState> = listOf(
                            state.pipeStateList[0].correct(),
                            state.pipeStateList[1].correct()
                        )
                        // 重置小鸟宽高
                        BirdSizeHeight = PipeDistance * BirdPipeDistanceFraction
                        BirdSizeWidth = BirdSizeHeight * 1.44f
                        val newBirdState = state.birdState.correct()

                        state.copy(
                            birdState = newBirdState,
                            pipeStateList = newPipeStateList
                        )
                    }

                    // 自动前进并下落
                    GameAction.AutoTick -> run {
                        // Do nothing when still waiting.
                        if (state.gameStatus == GameStatus.Waiting) {
                            return@run state
                        }
                        // Only quick fall when dying status.
                        if (state.gameStatus == GameStatus.Dying) {
                            val newBirdState = state.birdState.quickFall()
                            return@run state.copy(
                                birdState = newBirdState
                            )
                        }
                        if (state.gameStatus == GameStatus.Over) {
                            return@run state.copy()
                        }
                        // Move pipes left.
                        val newPipeStateList: List<PipeState> = listOf(
                            state.pipeStateList[0].move(),
                            state.pipeStateList[1].move()
                        )
                        // Bird fall.
                        val newBirdState = state.birdState.fall()
                        // Move road.
                        val newRoadStateList: List<RoadState> = listOf(
                            state.roadStateList[0].move(),
                            state.roadStateList[1].move()
                        )

                        state.copy(
                            gameStatus = GameStatus.Running,
                            birdState = newBirdState,
                            pipeStateList = newPipeStateList,
                            roadStateList = newRoadStateList
                        )
                    }

                    GameAction.Start -> run {
                        state.copy(
                            gameStatus = GameStatus.Running,
                        )
                    }

                    GameAction.TouchLift -> run {
                        if (state.gameStatus == GameStatus.Over) {
                            return@run state.copy()
                        }
                        // Not lift when already dying.
                        if (state.gameStatus == GameStatus.Dying) {
                            return@run state.copy()
                        }
                        // Bird lift
                        val newBirdState = state.birdState.lift()
                        state.copy(
                            gameStatus = GameStatus.Running,
                            birdState = newBirdState
                        )
                    }

                    GameAction.PipeExit -> run {
                        val newPipeStateList: List<PipeState> =
                            if (state.targetPipeIndex == 0) {
                                listOf(
                                    state.pipeStateList[0].reset(),
                                    state.pipeStateList[1]
                                )
                            } else {
                                listOf(
                                    state.pipeStateList[0],
                                    state.pipeStateList[1].reset()
                                )
                            }

                        state.copy(
                            gameStatus = GameStatus.Running,
                            pipeStateList = newPipeStateList
                        )
                    }

                    GameAction.RoadExit -> run {
                        val newRoadState: List<RoadState> =
                            if (state.targetRoadIndex == 0) {
                                listOf(
                                    state.roadStateList[0].reset(),
                                    state.roadStateList[1]
                                )
                            } else {
                                listOf(
                                    state.roadStateList[0],
                                    state.roadStateList[1].reset()
                                )
                            }

                        state.copy(
                            gameStatus = GameStatus.Running,
                            roadStateList = newRoadState
                        )
                    }

                    GameAction.HitGround -> run {
                        state.copy(
                            gameStatus = GameStatus.Over
                        )
                    }

                    GameAction.HitPipe -> run {
                        if (state.gameStatus == GameStatus.Dying) {
                            return@run state.copy()
                        }
                        // Bird fall.
                        val newBirdState = state.birdState.quickFall()

                        state.copy(
                            gameStatus = GameStatus.Dying,
                            birdState = newBirdState
                        )
                    }

                    GameAction.CrossedPipe -> run {
                        val targetPipeState = state.pipeStateList[state.targetPipeIndex]

                        // Need consider pipe's offset due to reset flag but count action triggered.
                        // Not update score when current pipe already calculated.
                        if (targetPipeState.counted
                                || (!targetPipeState.counted && targetPipeState.offset > 0.dp)) {
                            return@run state.copy()
                        }

                        // Mark current pipe.
                        val countedPipeState = targetPipeState.count()
                        val newPipeStateList = if (state.targetPipeIndex == 0) {
                            listOf(
                                countedPipeState,
                                state.pipeStateList[1]
                            )
                        } else {
                            listOf(
                                state.pipeStateList[0],
                                countedPipeState
                            )
                        }

                        state.copy(
                            pipeStateList = newPipeStateList,
                            score = state.score + 1,
                            bestScore = (state.score + 1).coerceAtLeast(state.bestScore)
                        )
                    }

                    GameAction.Restart -> run {
                        // Keep max score status.
                        state.reset(state.bestScore)
                    }

                   // GameAction.Pause -> run {
                   //     state.copy(
                   //         gameStatus = GameStatus.Paused
                   //     )
                   // }
                   //
                   // GameAction.Resume -> run {
                   //     state.copy(
                   //         gameStatus = GameStatus.Running
                   //     )
                   // }

                })
            }
        }
    }

    private fun emit(state: ViewState) {
        _viewState.value = state
    }
}