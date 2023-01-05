package com.zj.play.home

import android.annotation.SuppressLint
import android.app.Application
import android.util.Log
import com.bumptech.glide.Glide
import com.bumptech.glide.RequestBuilder
import com.bumptech.glide.RequestManager
import com.bumptech.glide.load.DataSource
import com.bumptech.glide.load.engine.GlideException
import com.bumptech.glide.request.RequestListener
import com.bumptech.glide.request.target.Target
import com.zj.core.util.DataStoreUtils
import com.zj.model.pojo.QueryHomeArticle
import com.zj.model.room.PlayDatabase
import com.zj.model.room.dao.BannerBeanDao
import com.zj.model.room.entity.Article
import com.zj.model.room.entity.BannerBean
import com.zj.model.room.entity.HOME
import com.zj.model.room.entity.HOME_TOP
import com.zj.network.base.PlayAndroidNetwork
import com.zj.play.base.liveDataFire
import dagger.hilt.android.scopes.ActivityRetainedScoped
import kotlinx.coroutines.*
import kotlinx.coroutines.flow.first
import java.io.File
import javax.inject.Inject

@ActivityRetainedScoped
class HomeRepository @Inject constructor(val application: Application) {

    /**
     * 获取banner
     */
    fun getBanner() = liveDataFire {
        val dataStore = DataStoreUtils
        var downImageTime = 0L
        dataStore.readLongFlow(DOWN_IMAGE_TIME, System.currentTimeMillis()).first {
            downImageTime = it
            true
        }
        // 获得数据库内banner
        val bannerBeanDao = PlayDatabase.getDatabase(application).bannerBeanDao()
        val bannerBeanList = bannerBeanDao.getBannerBeanList()
        // 数据库banner一天内有效
        if (bannerBeanList.isNotEmpty() && downImageTime > 0 && downImageTime - System.currentTimeMillis() < ONE_DAY) {
            Result.success(bannerBeanList)
        } else {
            val bannerResponse = PlayAndroidNetwork.getBanner()
            if (bannerResponse.errorCode == 0) {
                val bannerList = bannerResponse.data
                dataStore.saveLongData(DOWN_IMAGE_TIME, System.currentTimeMillis())
                // 使用数据库banner,如果第一个Banner重复
                if (bannerBeanList.isNotEmpty() && bannerBeanList[0].url == bannerList[0].url) {
                    Result.success(bannerBeanList)
                } else {
                    bannerBeanDao.deleteAll()
                    insertBannerList(bannerBeanDao, bannerList)
                    Result.success(bannerList)
                }
            } else {
                Result.failure(RuntimeException("response status is ${bannerResponse.errorCode}  msg is ${bannerResponse.errorMsg}"))
            }
        }
    }

    @SuppressLint("CheckResult")
    private suspend fun insertBannerList(
        bannerBeanDao: BannerBeanDao,
        bannerList: List<BannerBean>
    ) {
        val uiScope = CoroutineScope(Dispatchers.IO + SupervisorJob())
        bannerList.forEach {
            val mRequestManager: RequestManager = Glide.with(application)
            val mRequestBuilder: RequestBuilder<File> = mRequestManager.downloadOnly()
            mRequestBuilder.load(it.imagePath)
            // 监听图片加载成功入库
            mRequestBuilder.listener(object : RequestListener<File> {
                override fun onLoadFailed(
                    e: GlideException?, model: Any?, target: Target<File>?, isFirstResource: Boolean
                ): Boolean {
                    Log.e("ZHUJIANG", "insertBannerList onLoadFailed: ${e?.message}")
                    return false
                }

                override fun onResourceReady(
                    resource: File?,
                    model: Any?,
                    target: Target<File>?,
                    dataSource: DataSource?,
                    isFirstResource: Boolean
                ): Boolean {
                    try {
                        it.filePath = resource?.absolutePath ?: ""
                        uiScope.launch {
                            if (it.filePath.isNotEmpty()) {
                                bannerBeanDao.insert(it)
                            }
                        }
                    } catch (e: Exception) {
                        e.printStackTrace()
                        Log.e("ZHUJIANG", "insertBannerList onResourceReady: ${e.message}")
                    }
                    return false
                }
            })
            mRequestBuilder.preload()
        }
    }

    /**
     * 首页获取文章列表
     * @param query 查询条件
     */
    fun getArticleList(query: QueryHomeArticle) = liveDataFire {
        coroutineScope {
            val res = arrayListOf<Article>()
            if (query.page == 1) {
                // 置顶文章
                // 获取本地数据
                val dataStore = DataStoreUtils
                val articleListDao = PlayDatabase.getDatabase(application).browseHistoryDao()
                val articleListTop = articleListDao.getTopArticleList(HOME_TOP)
                var downTopArticleTime = 0L
                dataStore.readLongFlow(DOWN_TOP_ARTICLE_TIME, System.currentTimeMillis()).first {
                    downTopArticleTime = it
                    true
                }
                // 本地有值且未过期
                if (articleListTop.isNotEmpty() && downTopArticleTime > 0 &&
                    downTopArticleTime - System.currentTimeMillis() < FOUR_HOUR && !query.isRefresh
                ) {
                    res.addAll(articleListTop)
                } else {
                    // 取远程数据
                    val topArticleListDeferred =
                        async { PlayAndroidNetwork.getTopArticleList() }
                    val topArticleList = topArticleListDeferred.await()
                    if (topArticleList.errorCode == 0) {
                        // 本地有数据且与远程头条文章相同
                        if (articleListTop.isNotEmpty() && articleListTop[0].link == topArticleList.data[0].link && !query.isRefresh) {
                            res.addAll(articleListTop)
                        } else {
                            res.addAll(topArticleList.data)
                            // 循环赋值
                            topArticleList.data.forEach {
                                it.localType = HOME_TOP
                            }
                            // 更新拉取时间
                            dataStore.saveLongData(
                                DOWN_TOP_ARTICLE_TIME,
                                System.currentTimeMillis()
                            )
                            // 更新本地数据
                            articleListDao.deleteAll(HOME_TOP)
                            articleListDao.insertList(topArticleList.data)
                        }
                    }
                }
                // 文章
                val articleListHome = articleListDao.getArticleList(HOME)
                var downArticleTime = 0L
                dataStore.readLongFlow(DOWN_ARTICLE_TIME, System.currentTimeMillis()).first {
                    downArticleTime = it
                    true
                }
                // 本地有值且未过期
                if (articleListHome.isNotEmpty() && downArticleTime > 0 && downArticleTime - System.currentTimeMillis() < FOUR_HOUR
                    && !query.isRefresh
                ) {
                    res.addAll(articleListHome)
                    Result.success(res)
                } else {
                    // 获取远程文章
                    val articleListDeferred =
                        async { PlayAndroidNetwork.getArticleList(query.page - 1) }
                    val articleList = articleListDeferred.await()
                    if (articleList.errorCode == 0) {
                        if (articleListHome.isNotEmpty() && articleListHome[0].link == articleList.data.datas[0].link && !query.isRefresh) {
                            res.addAll(articleListHome)
                        } else {
                            res.addAll(articleList.data.datas)
                            articleList.data.datas.forEach {
                                it.localType = HOME
                            }
                            dataStore.saveLongData(DOWN_ARTICLE_TIME, System.currentTimeMillis())
                            articleListDao.deleteAll(HOME)
                            articleListDao.insertList(articleList.data.datas)
                        }
                        Result.success(res)
                    } else {
                        Result.failure(
                            RuntimeException(
                                "response status is ${articleList.errorCode}" + "  msg is ${articleList.errorMsg}"
                            )
                        )
                    }
                }
            } else {
                val articleListDeferred =
                    async { PlayAndroidNetwork.getArticleList(query.page - 1) }
                val articleList = articleListDeferred.await()
                if (articleList.errorCode == 0) {
                    res.addAll(articleList.data.datas)
                    Result.success(res)
                } else {
                    Result.failure(
                        RuntimeException(
                            "response status is ${articleList.errorCode}" + "  msg is ${articleList.errorMsg}"
                        )
                    )
                }
            }
        }
    }

}

const val ONE_DAY = 1000 * 60 * 60 * 24
const val FOUR_HOUR = 1000 * 60 * 60 * 4
const val DOWN_IMAGE_TIME = "DownImageTime"
const val DOWN_TOP_ARTICLE_TIME = "DownTopArticleTime"
const val DOWN_ARTICLE_TIME = "DownArticleTime"
const val DOWN_PROJECT_ARTICLE_TIME = "DownProjectArticleTime"
const val DOWN_OFFICIAL_ARTICLE_TIME = "DownOfficialArticleTime"