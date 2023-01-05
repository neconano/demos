package com.zj.play.profile.history

import androidx.lifecycle.LiveData
import com.zj.core.view.base.BaseAndroidViewModel
import com.zj.model.room.entity.Article
import dagger.hilt.android.lifecycle.HiltViewModel
import javax.inject.Inject

@HiltViewModel
class BrowseHistoryViewModel @Inject constructor(
    private val browseHistoryRepository: BrowseHistoryRepository
) : BaseAndroidViewModel<List<Article>, Article, Int>() {

    override fun getData(page: Int): LiveData<Result<List<Article>>> {
        return browseHistoryRepository.getBrowseHistory(page)
    }

}