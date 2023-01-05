package com.zj.play.home

import android.content.BroadcastReceiver
import android.os.Bundle
import com.zj.core.view.base.BaseActivity
import com.zj.play.article.ArticleBroadCast

/**
 * 描述：文章收藏 BaseActivity，注册文章收藏状态改变的广播
 *
 */
abstract class ArticleCollectBaseActivity : BaseActivity() {

    private var articleReceiver: BroadcastReceiver? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        articleReceiver =
            ArticleBroadCast.setArticleChangesReceiver(this) { initData() }
    }

    override fun onDestroy() {
        super.onDestroy()
        ArticleBroadCast.clearArticleChangesReceiver(this, articleReceiver)
    }

}