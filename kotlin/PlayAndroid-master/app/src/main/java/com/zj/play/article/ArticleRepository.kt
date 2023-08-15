package com.zj.play.article

import android.app.Application
import com.zj.core.Play
import com.zj.core.util.showToast
import com.zj.play.R
import com.zj.play.article.collect.CollectRepositoryPoint
import dagger.hilt.android.EntryPointAccessors
import dagger.hilt.android.scopes.ActivityRetainedScoped
import kotlinx.coroutines.*
import kotlinx.coroutines.flow.collectLatest
import javax.inject.Inject

/**
 * 版权：联想 版权所有
 *
 * @author zhujiang
 * 创建日期：2020/11/7
 * 描述：PlayAndroid
 *
 */
@ActivityRetainedScoped
class ArticleRepository @Inject constructor(val application: Application) :
    CoroutineScope by MainScope() {

    suspend fun setCollect(
        isCollection: Int,
        pageId: Int,
        originId: Int,
        collectListener: (Boolean) -> Unit
    ) {
        coroutineScope {
            launch {
                Play.isLogin().collectLatest {
                    if (!it) {
                        application.showToast(R.string.not_currently_logged_in)
                        return@collectLatest
                    }
                }
            }
        }

        if (isCollection == -1 || pageId == -1) {
            application.showToast(R.string.page_is_not_collection)
            return
        }
        val collectRepository = EntryPointAccessors.fromApplication(
            application,
            CollectRepositoryPoint::class.java
        ).collectRepository()
        withContext(Dispatchers.IO) {
            if (isCollection == 1) {
                val cancelCollects =
                    collectRepository.cancelCollects(if (originId != -1) originId else pageId)
                if (cancelCollects.errorCode == 0) {
                    application.showToast(R.string.collection_cancelled_successfully)
                    ArticleBroadCast.sendArticleChangesReceiver(application)
                    collectListener.invoke(false)
                } else {
                    application.showToast(R.string.failed_to_cancel_collection)
                }
            } else {
                val toCollects = collectRepository.toCollects(pageId)
                if (toCollects.errorCode == 0) {
                    application.showToast(R.string.collection_successful)
                    ArticleBroadCast.sendArticleChangesReceiver(application)
                    collectListener.invoke(true)
                } else {
                    application.showToast(R.string.collection_failed)
                }

            }
        }

    }

}