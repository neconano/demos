package com.zj.core.view.base

import android.annotation.SuppressLint
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.Transformations
import androidx.lifecycle.ViewModel

abstract class BaseAndroidViewModel<BaseData, Data, Key> : ViewModel() {

    // 最终使用数据
    val dataList = ArrayList<Data>()

    // 定义预处理数据类型 LiveData
    private val pageLiveData = MutableLiveData<Key>()

    // 需要实现的获取数据方法，由具体业务Model实现，返回格式为 Result
    abstract fun getData(page: Key): LiveData<Result<BaseData>>

    // 观察 pageLiveData，参数二方法处理后返回 LiveData
    val dataLiveData = Transformations.switchMap(pageLiveData) { page ->
        getData(page)
    }

    // 获得数据
    // page 触发 pageLiveData 观察者，page 不分页数据为boolean, 分页数据为int
    @SuppressLint("NullSafeMutableLiveData")
    fun getDataList(page: Key) {
        pageLiveData.value = page
    }

}