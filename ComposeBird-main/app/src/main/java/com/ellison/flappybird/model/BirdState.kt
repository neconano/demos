package com.ellison.flappybird.model

import androidx.compose.ui.unit.Dp
import androidx.compose.ui.unit.dp

data class BirdState(
    var birdHeight: Dp = DefaultBirdHeightOffset, // 默认坐标，坐标系根据显示位置调整
    var isLifting: Boolean = false,
    var birdH: Dp = BirdSizeHeight, //小鸟高
    var birdW: Dp = BirdSizeWidth // 小鸟宽
) {
    fun lift(): BirdState =
        copy(birdHeight = birdHeight - BirdLiftVelocity, isLifting = true)

    fun fall(): BirdState =
        copy(birdHeight = birdHeight + BirdFallVelocity, isLifting = false)

    fun over(groundOffset: Dp): BirdState =
        copy(birdHeight = groundOffset)

    fun quickFall(): BirdState =
        copy(birdHeight = birdHeight + BirdQuickFallVelocity)

    fun correct(): BirdState =
        copy(birdH = BirdSizeHeight, birdW = BirdSizeWidth)
}

// 居中显示，高度坐标0
val DefaultBirdHeightOffset = 0.dp
// 小鸟尺寸高度系数
const val BirdPipeDistanceFraction = 0.20f
// 小鸟宽高
var BirdSizeHeight = PipeDistance * BirdPipeDistanceFraction
var BirdSizeWidth = BirdSizeHeight * 1.44f
// 小鸟撞地起始高度，避免穿模
val BirdHitGroundThreshold = BirdSizeHeight / 2
// 下落速度
var BirdFallVelocity = 8.dp
// 快速下落
var BirdQuickFallVelocity = BirdFallVelocity * 4
// 上升速度
val BirdLiftVelocity = BirdFallVelocity * 8

