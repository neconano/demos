package com.zj.core.view.custom

import androidx.fragment.app.Fragment
import androidx.fragment.app.FragmentManager
import androidx.lifecycle.Lifecycle
import androidx.viewpager2.adapter.FragmentStateAdapter

class FragmentAdapter(mFragmentManager: FragmentManager, lifecycle: Lifecycle) :
    FragmentStateAdapter(
        mFragmentManager, lifecycle
    ) {
    private val mFragment: MutableList<Fragment> = ArrayList()
    private lateinit var mTitles: Array<String>

    fun title(position: Int): String {
        return mTitles[position]
    }

    fun reset(titles: Array<String>) {
        mTitles = titles
    }

    fun reset(fragments: List<Fragment>?) {
        fragments?.apply {
            mFragment.clear()
            mFragment.addAll(this)
        }
    }

    override fun getItemCount(): Int {
        return mFragment.size
    }

    override fun createFragment(position: Int): Fragment {
        return mFragment[position]
    }
}