package com.zj.play

import android.annotation.SuppressLint
import android.view.KeyEvent
import android.view.View
import android.view.animation.*
import com.zj.core.util.showToast
import com.zj.core.view.base.BaseActivity
import com.zj.play.databinding.ActivityWelcomeBinding
import com.zj.play.main.MainActivity

class WelcomeActivity : BaseActivity(),
    View.OnClickListener {

    private lateinit var binding: ActivityWelcomeBinding
    private var exitTime: Long = 0
    private var animationTime: Long = 500

    private val animationListener = object : Animation.AnimationListener {
        /**
         * 动画开始的时候执行
         * @param animation
         */
        override fun onAnimationStart(animation: Animation) {}

        /**
         * 动画结束的时候执行
         * @param animation
         */
        override fun onAnimationEnd(animation: Animation) {
            //跳转到登陆界面
            jump()
        }

        /**
         * 动画重复的时候执行
         * @param animation
         */
        override fun onAnimationRepeat(animation: Animation) {}
    }

    override fun getLayoutView(): View {
        binding = ActivityWelcomeBinding.inflate(layoutInflater)
        return binding.root
    }

    @SuppressLint("SetTextI18n")
    override fun initView() {
        binding.ivWelcomeBg.setOnClickListener(this)
        initAnimation()
    }

    private fun initAnimation() {
        // 渐变动画
        val alphaAnimation = AlphaAnimation(0f, 1f)
        alphaAnimation.duration = animationTime
        alphaAnimation.fillAfter = true

        val animationSet = AnimationSet(true)
        animationSet.addAnimation(alphaAnimation)
        binding.ivWelcomeBg.startAnimation(animationSet)
        animationSet.setAnimationListener(animationListener)
    }

    private fun jump() {
        MainActivity.actionStart(this)
        finish()
    }

    override fun onClick(v: View) {
        when (v.id) {
            R.id.ivWelcomeBg -> {
                jump()
            }
        }
    }

    override fun onKeyDown(keyCode: Int, event: KeyEvent): Boolean {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            exit()
            return false
        }
        return super.onKeyDown(keyCode, event)
    }

    private fun exit() {
        if (System.currentTimeMillis() - exitTime > 2000) {
            showToast(R.string.exit_program)
            exitTime = System.currentTimeMillis()
        } else {
            finish()
        }
    }

}
