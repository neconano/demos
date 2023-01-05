package com.ellison.flappybird.view

import android.util.Log
import android.view.MotionEvent
import android.view.MotionEvent.ACTION_DOWN
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.ExperimentalComposeUiApi
import androidx.compose.ui.Modifier
import androidx.compose.ui.input.pointer.pointerInteropFilter
import androidx.compose.ui.layout.onGloballyPositioned
import androidx.compose.ui.platform.LocalDensity
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.Dp
import androidx.lifecycle.viewmodel.compose.viewModel
import com.ellison.flappybird.*
import com.ellison.flappybird.model.*
import com.ellison.flappybird.ui.theme.ForegroundEarthYellow
import com.ellison.flappybird.util.LogUtil
import com.ellison.flappybird.viewmodel.GameViewModel

@Preview(widthDp = 411, heightDp = 840)
@Composable
fun PreviewGameScreen() {
    Column(
        modifier = Modifier
            .fillMaxSize()
            .background(ForegroundEarthYellow)
    ) {
        Box(modifier = Modifier
            .align(Alignment.CenterHorizontally)
            .fillMaxWidth()
            .fillMaxHeight(0.85f)
        ) {
            FarBackground(Modifier.fillMaxSize())
            PipeScreen()
            PreviewBird()
            RealTimeBoardPreview()
        }
        previewForeground()
    }
}


@OptIn(ExperimentalComposeUiApi::class)
@Composable
fun GameScreen(
    clickable: Clickable = Clickable()
) {
    val viewModel: GameViewModel = viewModel()
    val viewState by viewModel.viewState.collectAsState()
    var screenSize: Pair<Int, Int>
    Column(
        modifier = Modifier
            .fillMaxSize()
            .background(ForegroundEarthYellow)
            .run {
                // 屏幕触摸事件
                pointerInteropFilter {
                    when (it.action) {
                        ACTION_DOWN -> {
                            if (viewState.gameStatus == GameStatus.Waiting)
                                clickable.onStart()
                            else if (viewState.gameStatus == GameStatus.Running)
                                clickable.onTap()
                            else
                                return@pointerInteropFilter false
                        }
                        MotionEvent.ACTION_MOVE -> {
                            return@pointerInteropFilter false
                        }
                        MotionEvent.ACTION_CANCEL, MotionEvent.ACTION_UP -> {
                            return@pointerInteropFilter false
                        }
                    }

                    false
                }
            }
    ) {
        Box(modifier = Modifier
            .align(Alignment.CenterHorizontally)
            .onGloballyPositioned {
                screenSize = Pair(it.size.width, it.size.height)
                // 初始化游戏参数，屏幕尺寸游戏区域及管道等
                if (viewState.playZoneSize.first <= 0 || viewState.playZoneSize.second <= 0) {
                    viewModel.dispatch(GameAction.ScreenSizeDetect, screenSize)
                }
            }
            .fillMaxWidth()
            .fillMaxHeight(0.85f)
        ) {
            FarBackground(Modifier.fillMaxSize())
            PipeCouple(
                modifier = Modifier.fillMaxSize(),
                state = viewState,
                pipeIndex = 0
            )
            PipeCouple(
                modifier = Modifier.fillMaxSize(),
                state = viewState,
                pipeIndex = 1
            )
            ScoreBoard(
                modifier = Modifier.fillMaxSize(),
                state = viewState,
                clickable = clickable
            )
            Bird(
                modifier = Modifier.fillMaxSize(),
                state = viewState
            )
            // 判断小鸟撞管道或穿过
            if (viewState.gameStatus == GameStatus.Running) {
                val playZoneWidthInDP = with(LocalDensity.current) {
                    viewState.playZoneSize.first.toDp()
                }
                val playZoneHeightInDP = with(LocalDensity.current) {
                    viewState.playZoneSize.second.toDp()
                }
                viewState.pipeStateList.forEachIndexed { pipeIndex, pipeState ->
                    // 小鸟与管道状态判断
                    CheckPipeStatus(
                        viewState.birdState.birdHeight,
                        pipeState,
                        playZoneWidthInDP,
                        playZoneHeightInDP
                    ).also {
                        when (it) {
                            PipeStatus.BirdHit -> {
                                viewModel.dispatch(GameAction.HitPipe)
                            }
                            PipeStatus.BirdCrossed -> {
                                viewModel.dispatch(GameAction.CrossedPipe, pipeIndex = pipeIndex)
                            }
                            else -> {}
                        }
                    }
                }
            }
        }

        Box(modifier = Modifier
            .align(Alignment.CenterHorizontally)
            .fillMaxWidth()
            .fillMaxHeight(0.15f)
        ) {
            NearForeground(
                modifier = Modifier.fillMaxSize(),
                state = viewState
            )
        }

    }
}

// 小鸟与管道状态判断
@Composable
fun CheckPipeStatus(birdHeightOffset: Dp, pipeState: PipeState, zoneWidth: Dp, zoneHeight: Dp): PipeStatus {
    if (pipeState.offset - PipeCoverWidth > - zoneWidth / 2 + BirdSizeWidth / 2) {
        // 如果管道的位置 > 屏幕的中央 ，则状态为BirdComing
        return PipeStatus.BirdComing
    } else if (pipeState.offset - PipeCoverWidth < - zoneWidth / 2 - BirdSizeWidth / 2) {
        // 管道 < 屏幕中央
        return PipeStatus.BirdCrossed
    } else {
        // 左上角为坐标系
        // 小鸟最上坐标
        val birdTop = (zoneHeight - BirdSizeHeight) / 2 + birdHeightOffset
        // 小鸟最下坐标
        val birdBottom = (zoneHeight + BirdSizeHeight) / 2 + birdHeightOffset
        // 判断小鸟撞管道
        if (birdTop < pipeState.upHeight || birdBottom > zoneHeight - pipeState.downHeight) {
            return PipeStatus.BirdHit
        }
        return PipeStatus.BirdCrossing
    }
 }

data class Clickable(
    val onStart: () -> Unit = {},
    val onTap: () -> Unit = {},
    val onRestart: () -> Unit = {},
    val onExit: () -> Unit = {}
)