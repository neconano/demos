package com.zj.play.profile.rank

import com.zj.network.base.PlayAndroidNetwork
import com.zj.play.base.liveDataModel
import dagger.hilt.android.scopes.ActivityRetainedScoped
import javax.inject.Inject

/**
 * 版权：Zhujiang 个人版权
 * @author zhujiang
 * 版本：1.5
 * 创建日期：2020/5/19
 * 描述：PlayAndroid
 *
 */
@ActivityRetainedScoped
class RankRepository @Inject constructor(){

    /**
     * 获取排行榜列表
     *
     * @param page 页码
     */
    fun getRankList(page: Int) = liveDataModel { PlayAndroidNetwork.getRankList(page) }

    /**
     * 获取个人积分获取列表
     *
     * @param page 页码
     */
    fun getUserRank(page: Int) = liveDataModel { PlayAndroidNetwork.getUserRank(page) }

    /**
     * 获取个人积分信息
     */
    fun getUserInfo() = liveDataModel { PlayAndroidNetwork.getUserInfo() }


}