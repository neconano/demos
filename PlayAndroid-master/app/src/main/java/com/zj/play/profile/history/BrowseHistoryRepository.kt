package com.zj.play.profile.history

import android.app.Application
import com.zj.model.room.PlayDatabase
import com.zj.model.room.entity.HISTORY
import com.zj.play.base.liveDataFire
import dagger.hilt.android.scopes.ActivityRetainedScoped
import javax.inject.Inject

@ActivityRetainedScoped
class BrowseHistoryRepository @Inject constructor(val application: Application) {

    private val browseHistoryDao = PlayDatabase.getDatabase(application).browseHistoryDao()

    /**
     * 获取历史记录列表
     */
    fun getBrowseHistory(page: Int) = liveDataFire {
        val projectClassifyLists = browseHistoryDao.getHistoryArticleList((page - 1) * 20,HISTORY)
        if (projectClassifyLists.isNotEmpty()) {
            Result.success(projectClassifyLists)
        } else {
            Result.failure(RuntimeException("response status is "))
        }

    }

}