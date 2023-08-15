package com.ellison.flappybird.view

import android.util.Log
import androidx.compose.foundation.layout.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.platform.LocalDensity
import androidx.lifecycle.viewmodel.compose.viewModel
import com.ellison.flappybird.model.*
import com.ellison.flappybird.util.LogUtil
import com.ellison.flappybird.viewmodel.GameViewModel

@Preview(widthDp = 411, heightDp = 660)
@Composable
fun PipeScreen() {
    val pipeState = PreviewPipeState
    Box(
        modifier = Modifier.fillMaxSize()
    ) {
        GetUpPipe(height = pipeState.upHeight,
            modifier = Modifier
                .align(Alignment.TopEnd)
                .offset(x = pipeState.offset)
        )

        GetDownPipe(height = pipeState.downHeight,
            modifier = Modifier
                .align(Alignment.BottomEnd)
                .offset(x = pipeState.offset)
        )
    }
}

@Composable
fun PipeCouple(
    modifier: Modifier = Modifier,
    state: ViewState = ViewState(),
    pipeIndex: Int = 0
) {
    val viewModel: GameViewModel = viewModel()
    val pipeState = state.pipeStateList[pipeIndex]
    Box(
        modifier
    ) {
        GetUpPipe(height = pipeState.upHeight,
            modifier = Modifier
                .align(Alignment.TopEnd)
                .offset(x = pipeState.offset)
        )
        GetDownPipe(height = pipeState.downHeight,
            modifier = Modifier
                .align(Alignment.BottomEnd)
                .offset(x = pipeState.offset)
        )
        if (state.playZoneSize.first > 0) {
            // 通过LocalDensity.current获取屏幕像素密度 562.0.dp
            val playZoneWidthInDP = with(LocalDensity.current) {
                state.playZoneSize.first.toDp()
            }
            // 管道移出屏幕后重置
            if (pipeState.offset < - playZoneWidthInDP - PipeResetThreshold) {
                viewModel.dispatch(GameAction.PipeExit, pipeIndex = pipeIndex)
            }
        }
    }
}
