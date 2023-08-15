package com.ellison.flappybird.view

import androidx.compose.foundation.Image
import androidx.compose.foundation.layout.*
import androidx.compose.material.Divider
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import com.ellison.flappybird.util.LogUtil
import com.ellison.flappybird.ui.theme.GroundDividerPurple
import com.ellison.flappybird.R
import com.ellison.flappybird.model.TempRoadWidthOffset
import com.ellison.flappybird.model.GameAction
import com.ellison.flappybird.model.ViewState
import com.ellison.flappybird.viewmodel.GameViewModel

@Preview(widthDp = 411, heightDp = 180)
@Composable
fun previewForeground() {
    Column(
        modifier = Modifier.fillMaxSize()
    ) {
        Divider(
            color = GroundDividerPurple,
            thickness = 5.dp
        )
        // Road
        Box(modifier = Modifier.fillMaxWidth()) {
            Image(
                painter = painterResource(id = R.drawable.foreground_road),
                contentScale = ContentScale.FillBounds,
                contentDescription = null,
                modifier = Modifier
                    .fillMaxWidth()
                    .fillMaxHeight(0.23f)
                    .offset(x = (-10).dp)
            )
            Image(
                painter = painterResource(id = R.drawable.foreground_road),
                contentScale = ContentScale.FillBounds,
                contentDescription = null,
                modifier = Modifier
                    .fillMaxWidth()
                    .fillMaxHeight(0.23f)
                    .offset(x = 10.dp)
            )
        }
        // Earth
        Image(
            painter = painterResource(id = R.drawable.foreground_earth),
            contentScale = ContentScale.FillBounds,
            contentDescription = null,
            modifier = Modifier
                .fillMaxWidth()
                .fillMaxHeight(0.77f)
        )
    }
}

@Composable
fun NearForeground(
    modifier: Modifier = Modifier,
    state: ViewState = ViewState()
) {
    val viewModel: GameViewModel = viewModel()
    Column(
        modifier
    ) {
        Divider(
            color = GroundDividerPurple,
            thickness = 5.dp
        )
        // Road
        Box(modifier = Modifier.fillMaxWidth()) {
            state.roadStateList.forEach { roadState ->
                Image(
                    painter = painterResource(id = R.drawable.foreground_road),
                    contentScale = ContentScale.FillBounds,
                    contentDescription = null,
                    modifier = modifier
                        .fillMaxWidth()
                        .fillMaxHeight(0.23f)
                        .offset(x = roadState.offset)
                )
            }
        }
        // Earth
        Image(
            painter = painterResource(id = R.drawable.foreground_earth),
            contentScale = ContentScale.FillBounds,
            contentDescription = null,
            modifier = modifier
                .fillMaxWidth()
                .fillMaxHeight(0.77f)
        )

        if (state.playZoneSize.first > 0) {
            state.roadStateList.forEachIndexed { index, roadState ->
                // 如果路被移出屏幕，则重置
                if (roadState.offset <= - TempRoadWidthOffset) {
                    viewModel.dispatch(GameAction.RoadExit, roadIndex = index)
                }
            }
        }
    }
}

