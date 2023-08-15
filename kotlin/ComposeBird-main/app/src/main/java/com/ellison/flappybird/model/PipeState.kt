package com.ellison.flappybird.model

import androidx.compose.ui.unit.Dp
import androidx.compose.ui.unit.dp
import com.ellison.flappybird.MoveVelocity
import com.ellison.flappybird.util.ValueUtil

data class PipeState (
    var offset: Dp = FirstPipeWidthOffset,
    var upHeight: Dp = ValueUtil.getRandomDp(LowPipe, HighPipe),
    var downHeight: Dp = TotalPipeHeight - upHeight - PipeDistance,
    var counted: Boolean = false
) {
    fun move(): PipeState =
        copy(offset = offset - MoveVelocity)

    fun count(): PipeState =
        copy(counted = true)

    // 重置上下管道高度，上管道范围内随机
    fun correct(): PipeState {
        val newUpHeight = ValueUtil.getRandomDp(LowPipe, HighPipe)
        return copy(
            upHeight = newUpHeight,
            downHeight = TotalPipeHeight - newUpHeight - PipeDistance
        )
    }

    fun reset(): PipeState {
        val newUpHeight = ValueUtil.getRandomDp(LowPipe, HighPipe)
        return copy(
            upHeight = newUpHeight,
            downHeight = TotalPipeHeight - newUpHeight - PipeDistance,
            offset = FirstPipeWidthOffset,
            counted = false
        )
    }
}

enum class PipeStatus {
    BirdComing,
    BirdHit,
    BirdCrossing,
    BirdCrossed
}

// 管道占屏幕高度的最大和最小长度
const val MaxPipeFraction = 0.4f
const val MinPipeFraction = 0.2f
const val CenterPipeFraction = (MaxPipeFraction + MinPipeFraction) / 2
// 上下管道口间距
const val PipeDistanceFraction = 1.0f - MaxPipeFraction - MinPipeFraction
// 默认屏幕高度
var TotalPipeHeight = 660.dp
// 上管道由max,min,center三种长度组成，然后根据入口间距计算下管道长度
var HighPipe = TotalPipeHeight * MaxPipeFraction
var MiddlePipe = TotalPipeHeight * CenterPipeFraction
var LowPipe = TotalPipeHeight * MinPipeFraction
var PipeDistance = TotalPipeHeight * PipeDistanceFraction

// 管道口宽高
val PipeCoverWidth = 60.dp
val PipeCoverHeight = 30.dp
// 默认第一，第二管道初始位置
val TotalPipeWidth = 412.dp
val FirstPipeWidthOffset = PipeCoverWidth * 2 // 120.0.dp
val SecondPipeWidthOffset = (TotalPipeWidth + FirstPipeWidthOffset * 3) / 2 // 386.0.dp
val PipeStateList = listOf(
    PipeState(offset = FirstPipeWidthOffset),
    PipeState(offset = (SecondPipeWidthOffset))
)

// Means if reset pipe height and location immediately when pipe move out to screen.
val PipeResetThreshold = 0.dp // 32.dp

// 预览参数
val PreviewPipeWidthOffset = 0.dp
val PreviewPipeState = PipeState(
    offset = PreviewPipeWidthOffset,
    upHeight = MiddlePipe
)

