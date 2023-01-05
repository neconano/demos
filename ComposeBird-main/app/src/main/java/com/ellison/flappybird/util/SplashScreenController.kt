package com.ellison.flappybird.util

import android.animation.AnimatorSet
import android.animation.ObjectAnimator
import android.app.Application
import android.graphics.Path
import android.os.Build
import android.os.SystemClock
import android.util.Log
import android.view.View
import android.view.animation.AnticipateInterpolator
import androidx.annotation.RequiresApi
import androidx.core.animation.doOnEnd
import androidx.core.splashscreen.SplashScreen
import androidx.core.splashscreen.SplashScreenViewProvider
import com.ellison.flappybird.R
import com.ellison.flappybird.initTime
import com.ellison.flappybird.viewmodel.GameViewModel
import java.util.*

class SplashScreenController(
    private val splashScreen: SplashScreen,
    private val viewModel: GameViewModel
) {

    var exitDuration : Long = 0L

    private val defaultExitDuration: Long by lazy {
        viewModel.getApplication<Application>()
            .resources.getInteger(R.integer.splash_exit_total_duration).toLong()
    }

    fun customizeSplashScreen() {
        keepSplashScreenLonger()
        customizeSplashScreenExit()
    }

    // 强制显示闪屏指定时间
    private fun keepSplashScreenLonger() {
        splashScreen.setKeepVisibleCondition { !viewModel.isDataReady() }
    }

    // 闪屏结束移除动画
    private fun customizeSplashScreenExit() {
        // 监听启动画面的退出时机
        splashScreen.setOnExitAnimationListener { splashScreenViewProvider ->
            // Log.d(
            //     "Splash", "SplashScreen#onSplashScreenExit view:$splashScreenViewProvider"
            //             + " view:${splashScreenViewProvider.view}"
            //             + " icon:${splashScreenViewProvider.iconView}"
            // )

            // 定制退场效果的启动画面视图
            exitDuration = getRemainingDuration(splashScreenViewProvider)
            Log.i("exitDuration", "$exitDuration")

            // hookViewLayout(splashScreenViewProvider)
            val onExit = {
                // 移除，否则可能覆盖在实际画面上，遮挡内容
                splashScreenViewProvider.remove()
            }
            // 整体的退场动画
            showSplashExitAnimator(splashScreenViewProvider.view, onExit)
            // App Icon 单独退场
            // showSplashIconExitAnimator(splashScreenViewProvider.iconView, onExit)


        }
    }

    // Show exit animator for splash screen view.
    private fun showSplashExitAnimator(splashScreenView: View, onExit: () -> Unit = {}) {
        // Create your custom animation set.
        val slideUp = ObjectAnimator.ofFloat(
            splashScreenView,
            View.TRANSLATION_Y,
            0f,
            -splashScreenView.height.toFloat()
        )

        val slideLeft = ObjectAnimator.ofFloat(
            splashScreenView,
            View.TRANSLATION_X,
            0f,
            -splashScreenView.width.toFloat()
        )

        val scaleXOut = ObjectAnimator.ofFloat(
            splashScreenView,
            View.SCALE_X,
            1.0f,
            0f
        )

        val alphaOut = ObjectAnimator.ofFloat(
            splashScreenView,
            View.ALPHA,
            1f,
            0f
        )

        val scaleOut = ObjectAnimator.ofFloat(
            splashScreenView,
            View.SCALE_X,
            View.SCALE_Y,
            Path().apply {
                moveTo(1.0f, 1.0f)
                lineTo(0f, 0f)
            }
        )

        AnimatorSet().run {
            duration = exitDuration
            interpolator = AnticipateInterpolator()
            // 淡出效果
            playTogether(scaleOut, alphaOut)
            doOnEnd {
                onExit()
            }
            start()
        }
    }

    // Show exit animator for splash icon.
    private fun showSplashIconExitAnimator(iconView: View, onExit: () -> Unit = {}) {
        val alphaOut = ObjectAnimator.ofFloat(
            iconView,
            View.ALPHA,
            1f,
            0f
        )

        // Bird scale out animator.
        val scaleOut = ObjectAnimator.ofFloat(
            iconView,
            View.SCALE_X,
            View.SCALE_Y,
            Path().apply {
                moveTo(1.0f, 1.0f)
                lineTo(0.3f, 0.3f)
            }
        )

        // Bird slide up to center.
        val slideUp = ObjectAnimator.ofFloat(
            iconView,
            View.TRANSLATION_Y,
            0f,
            // iconView.translationY,
            -(iconView.height).toFloat() * 2.25f
        ).apply {
            addUpdateListener {
                Log.d("Splash", "showSplashIconExitAnimator() translationY:${iconView.translationY}")
            }
        }

        AnimatorSet().run {
            interpolator = AnticipateInterpolator()
            duration = exitDuration
            // Log.d("Splash", "showSplashIconExitAnimator() duration:$duration")

            playTogether(alphaOut, scaleOut, slideUp)
            // playTogether(scaleOut, slideUp)
            // playTogether(slideUp)

            doOnEnd {
                Log.d("Splash", "showSplashIconExitAnimator() onEnd remove")
                onExit()
            }

            start()
        }
    }

    @RequiresApi(Build.VERSION_CODES.M)
    private fun hookViewLayout(splashScreenViewProvider: SplashScreenViewProvider) {
        val rootWindowInsets = splashScreenViewProvider.view.rootWindowInsets

        // Log.d("Splash", "hookViewLayout() rootWindowInsets:$rootWindowInsets" +
        //         // "\n systemWindowInsets:${rootWindowInsets.systemWindowInsets}" +
        //         " top:${rootWindowInsets.systemWindowInsetTop}" +
        //         " bottom${rootWindowInsets.systemWindowInsetBottom}" +
        //         " icon translationY:${splashScreenViewProvider.iconView.translationY}")
    }

    // 用户跳过闪屏，控制退场动画的时长
    private fun getRemainingDuration(splashScreenView: SplashScreenViewProvider): Long {
        // Get the duration of the animated vector drawable.
        // 总时长
        val animationDuration = splashScreenView.iconAnimationDurationMillis
        // Get the start time of the animation.
        // 进场动画开始时刻
        val animationStart = splashScreenView.iconAnimationStartMillis
        // Calculate the remaining duration of the animation.
        // 如果闪屏没有动画效果是张图片情况
        // 否则，根据动画时长和执行时间，减少用户等待时间
        return if (animationDuration == 0L || animationStart == 0L)
            defaultExitDuration
        else (animationDuration - (SystemClock.uptimeMillis() - initTime) ).coerceAtLeast(0L)
    }
}