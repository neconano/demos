package com.ellison.flappybird.model

import androidx.compose.ui.unit.Dp
import androidx.compose.ui.unit.dp
import com.ellison.flappybird.MoveVelocity

data class RoadState (var offset: Dp = RoadWidthOffset) {
    fun move(): RoadState = copy(offset = offset - MoveVelocity)

    fun reset(): RoadState = copy(offset = TempRoadWidthOffset)
}

val RoadWidthOffset = 0.dp
val TempRoadWidthOffset = 300.dp

// 初始化两段路，1坐标是0，2是300（屏幕宽600），每段宽300
val RoadStateList = listOf(
    RoadState(),
    RoadState(offset = TempRoadWidthOffset)
)