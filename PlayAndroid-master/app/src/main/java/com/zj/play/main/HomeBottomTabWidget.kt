package com.zj.play.main

import android.content.Context
import android.util.AttributeSet
import android.view.LayoutInflater
import android.view.View
import android.widget.TextView
import com.zj.play.R
import com.zj.play.databinding.LayoutHomeBottomTabBinding


class HomeBottomTabWidget @JvmOverloads constructor(
    context: Context?,
    attrs: AttributeSet? = null,
    defStyleAttr: Int = 0
) : BaseHomeBottomTabWidget(context, attrs, defStyleAttr){

    private var textViews: ArrayList<TextView> = arrayListOf()

    /**
     * 初始化 设置点击事件。
     */
    init {
        val view = LayoutHomeBottomTabBinding.inflate(LayoutInflater.from(context), this, true)
        view.apply {
            textViews = arrayListOf(llHomeATHome, llHomeATCalendar, llHomeATObject, llHomeATMy)
        }
        for (textView in textViews) {
            textView.setOnClickListener(this)
        }
    }

    /**
     * 实现按钮的点击事件
     */
    override fun onClick(v: View) {
        when (v.id) {
            R.id.llHomeATHome -> fragmentManger(0)
            R.id.llHomeATCalendar -> fragmentManger(1)
            R.id.llHomeATObject -> fragmentManger(2)
            R.id.llHomeATMy -> fragmentManger(3)
        }
    }

    /**
     * fragment的切换 实现底部导航栏的切换
     */
    override fun fragmentManger(position: Int) {
        super.fragmentManger(position)
        for (j in textViews.indices) {
            textViews[j].isSelected = position == j
        }
    }

    /**
     * 销毁，避免内存泄漏
     */
    override fun destroy() {
        super.destroy()
        if (textViews.isNotEmpty()) {
            textViews.clear()
        }
    }

}