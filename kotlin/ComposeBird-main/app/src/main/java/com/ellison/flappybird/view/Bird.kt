package com.ellison.flappybird.view

import android.util.Log
import androidx.compose.foundation.Image
import androidx.compose.foundation.layout.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.rotate
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.platform.LocalDensity
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.tooling.preview.Preview
import androidx.lifecycle.viewmodel.compose.viewModel
import com.ellison.flappybird.R
import com.ellison.flappybird.model.*
import com.ellison.flappybird.util.LogUtil
import com.ellison.flappybird.viewmodel.GameViewModel

@Preview(widthDp = 411, heightDp = 660)
@Composable
fun PreviewBird() {
    Box(Modifier.fillMaxSize()) {
        Image(
            painter = painterResource(id = R.drawable.bird_match),
            contentScale = ContentScale.FillBounds,
            contentDescription = null,
            modifier = Modifier
                .size(BirdSizeWidth, BirdSizeHeight)
                .align(Alignment.Center)
                .offset(y = DefaultBirdHeightOffset)
        )
    }
}

@Composable
fun Bird(
    modifier: Modifier = Modifier,
    state: ViewState = ViewState()
) {
    Box(
        modifier
    ) {
        var correctBirdHeight = state.birdState.birdHeight
        // 撞地检测
        if (state.playZoneSize.second > 0) {
            val playZoneHeightInDP = with(LocalDensity.current) {
                state.playZoneSize.second.toDp()
            }
            // 居中显示，correctBirdHeight撞地值为playZoneHeightInDP（屏幕高度）的/2
            if (correctBirdHeight + BirdHitGroundThreshold >= playZoneHeightInDP / 2) {
                val viewModel: GameViewModel = viewModel()
                viewModel.dispatch(GameAction.HitGround)
                // Make sure bird not fall over ground.
                correctBirdHeight = playZoneHeightInDP / 2 - BirdHitGroundThreshold
            }
        }
        // Rotate 90 degree when quick falling / dying.
        val rotateDegree =
            if (state.isLifting) LiftingDegree
            else if (state.isFalling) FallingDegree
            else if (state.isQuickFalling) DyingDegree
            else if (state.isOver) DeadDegree
            else PendingDegree

        Image(
            painter = painterResource(id = R.drawable.bird_match),
            contentScale = ContentScale.FillBounds,
            contentDescription = null,
            modifier = Modifier
                .size(state.birdState.birdW, state.birdState.birdH)
                .align(Alignment.Center)
                .offset(y = correctBirdHeight)
                .rotate(rotateDegree)  // Rotate 90 degree when dying/ over.
        )
    }
}

// 执行动作时，小鸟反转角度
const val PendingDegree = 0f
const val LiftingDegree = -20f
const val FallingDegree = -LiftingDegree
const val DyingDegree = FallingDegree + 10f
const val DeadDegree = DyingDegree - 10f

