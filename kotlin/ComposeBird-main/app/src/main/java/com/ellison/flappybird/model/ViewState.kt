package com.ellison.flappybird.model

data class ViewState(
    // 屏幕宽高，1是宽，2是高，需要根据实际屏幕初始化
    var playZoneSize: Pair<Int, Int> = Pair(0, 0),
    //  初始化两个管道
    val pipeStateList: List<PipeState> = PipeStateList,
    // 标识需要重置的管道
    var targetPipeIndex: Int = -1,
    // 初始化两段路,用于显示移动效果
    val roadStateList: List<RoadState> = RoadStateList,
    // 标识需要重置的路
    var targetRoadIndex: Int = -1,
    // 默认游戏状态
    val gameStatus: GameStatus = GameStatus.Waiting,
    //
    val birdState: BirdState = BirdState(),
    val score: Int = 0,
    val bestScore: Int = 0,
) {
    val isLifting = gameStatus == GameStatus.Running && birdState.isLifting
    val isFalling get() = gameStatus == GameStatus.Running && !birdState.isLifting
    val isQuickFalling get() = gameStatus == GameStatus.Dying
    val isOver get() = gameStatus == GameStatus.Over

    fun reset(bestScore: Int): ViewState =
        ViewState(bestScore = bestScore)
}

enum class GameStatus {
    Waiting,
    Running,
    Dying,
    Over
}

sealed class GameAction {
    object Start : GameAction()
    object AutoTick : GameAction()
    object TouchLift : GameAction()

    object ScreenSizeDetect : GameAction()
    object PipeExit : GameAction()
    object RoadExit : GameAction()

    object HitPipe : GameAction()
    object HitGround : GameAction()
    object CrossedPipe : GameAction()

    object Restart : GameAction()
}