package com.ellison.flappybird

import android.animation.AnimatorSet
import android.animation.ObjectAnimator
import android.graphics.Path
import android.os.Build
import android.os.Bundle
import android.os.SystemClock
import android.util.Log
import android.view.View
import android.view.animation.AnticipateInterpolator
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.activity.viewModels
import androidx.annotation.RequiresApi
import androidx.compose.material.MaterialTheme
import androidx.compose.material.Surface
import androidx.compose.runtime.Composable
import androidx.compose.runtime.DisposableEffect
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.ui.platform.LocalLifecycleOwner
import androidx.compose.ui.unit.dp
import androidx.core.animation.doOnEnd
import androidx.core.splashscreen.SplashScreen
import androidx.core.splashscreen.SplashScreen.Companion.installSplashScreen
import androidx.lifecycle.Lifecycle
import androidx.lifecycle.LifecycleObserver
import androidx.lifecycle.OnLifecycleEvent
import androidx.lifecycle.viewmodel.compose.viewModel
import com.ellison.flappybird.model.GameAction
import com.ellison.flappybird.model.GameStatus
import com.ellison.flappybird.ui.theme.FlappyBirdTheme
import com.ellison.flappybird.util.SplashScreenController
import com.ellison.flappybird.util.StatusBarUtil
import com.ellison.flappybird.view.Clickable
import com.ellison.flappybird.view.GameScreen
import com.ellison.flappybird.viewmodel.GameViewModel
import kotlinx.coroutines.delay
import kotlinx.coroutines.isActive

class MainActivity : ComponentActivity() {

    private val viewModel: GameViewModel by viewModels()

    // `@RequiresApi(Build.VERSION_CODES.S)
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        // Expand screen to status bar.
        StatusBarUtil.transparentStatusBar(this)
        // Need to be called before setContentView or other view operation on the root view.
        // 覆写Activity，用以获取定制入口的静态成员函数
        val splashScreen = installSplashScreen()
        // AndroidManifest.xml设置闪屏后，设置闪屏动画
        SplashScreenController(splashScreen, viewModel).apply {
            customizeSplashScreen()
        }
        setContent {
            FlappyBirdTheme {
                Surface(color = MaterialTheme.colors.background) {
                    val gameViewModel: GameViewModel = viewModel()
                    // 游戏循环，每隔50毫秒延迟
                    LaunchedEffect(key1 = Unit) {
                        while (isActive) {
                            delay(AutoTickDuration)
                            if (gameViewModel.viewState.value.gameStatus != GameStatus.Waiting) {
                                gameViewModel.dispatch(GameAction.AutoTick)
                            }
                        }
                    }
                    // 初始化游戏界面，定义点击事件
                    InitGameScreen(Clickable(
                        onStart = {
                            gameViewModel.dispatch(GameAction.Start)
                        },
                        onTap = {
                            gameViewModel.dispatch(GameAction.TouchLift)
                        },
                        onRestart = {
                            gameViewModel.dispatch(GameAction.Restart)
                        },
                        onExit = {
                            finish()
                        }
                    ))

                    // 生命周期监听，应用切到后台，重新载入情况
                    // val lifecycleOwner = LocalLifecycleOwner.current
                    // DisposableEffect(key1 = Unit) {
                    //     val observer = object : LifecycleObserver {
                    //         @OnLifecycleEvent(Lifecycle.Event.ON_PAUSE)
                    //         fun onPause() {
                    //         }
                    //
                    //         @OnLifecycleEvent(Lifecycle.Event.ON_RESUME)
                    //         fun onResume() {
                    //         }
                    //     }
                    //
                    //     lifecycleOwner.lifecycle.addObserver(observer)
                    //     onDispose {
                    //         lifecycleOwner.lifecycle.removeObserver(observer)
                    //     }
                    // }
                }
            }
        }
    }
}

@Composable
fun InitGameScreen(clickable: Clickable = Clickable()) {
    GameScreen(clickable = clickable)
}

// 游戏循环，每隔50毫秒延迟
const val AutoTickDuration = 50L
// app起始毫秒数
val initTime = SystemClock.uptimeMillis()
// 移动速度
val MoveVelocity = 8.dp
