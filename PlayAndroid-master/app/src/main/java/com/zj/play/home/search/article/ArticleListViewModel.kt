package com.zj.play.home.search.article

import androidx.lifecycle.LiveData
import com.zj.core.view.base.BaseAndroidViewModel
import com.zj.model.model.ArticleList
import com.zj.model.room.entity.Article
import com.zj.play.home.search.SearchRepository
import dagger.hilt.android.lifecycle.HiltViewModel
import javax.inject.Inject

@HiltViewModel
class ArticleListViewModel @Inject constructor(
    private val searchRepository: SearchRepository
) : BaseAndroidViewModel<ArticleList, Article, QueryKeyArticle>() {

    override fun getData(page: QueryKeyArticle): LiveData<Result<ArticleList>> {
        return searchRepository.getQueryArticleList(page.page, page.k)
    }

}

data class QueryKeyArticle(var page: Int, var k: String)