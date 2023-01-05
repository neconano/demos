package com.zj.play.article.collect

import com.zj.network.base.PlayAndroidNetwork
import com.zj.play.base.liveDataModel
import dagger.hilt.EntryPoint
import dagger.hilt.InstallIn
import dagger.hilt.components.SingletonComponent
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class CollectRepository @Inject constructor() {

    /**
     * 获取收藏列表
     *
     * @param page 页码
     */
    fun getCollectList(page: Int) = liveDataModel { PlayAndroidNetwork.getCollectList(page) }

    suspend fun cancelCollects(id: Int) = PlayAndroidNetwork.cancelCollect(id)
    suspend fun toCollects(id: Int) = PlayAndroidNetwork.toCollect(id)

}

/**
* 全局保持单例，指定其装载到SingletonComponent中，也就是全局APP中
* */
@EntryPoint
@InstallIn(SingletonComponent::class)
interface CollectRepositoryPoint {
    fun collectRepository(): CollectRepository
}