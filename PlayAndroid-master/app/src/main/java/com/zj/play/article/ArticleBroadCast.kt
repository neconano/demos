package com.zj.play.article

import android.app.Activity
import android.content.BroadcastReceiver
import android.content.Context
import android.content.Intent
import android.content.IntentFilter
import android.util.Log
import androidx.localbroadcastmanager.content.LocalBroadcastManager

object ArticleBroadCast {

    const val COLLECT_RECEIVER = "com.zj.play.COLLECT"

    fun sendArticleChangesReceiver(context: Context) {
        val intent = Intent(COLLECT_RECEIVER)
        LocalBroadcastManager.getInstance(context).sendBroadcast(intent)
    }

    // 接收广播执行回调，用户登录退出影响收藏状态等
    fun setArticleChangesReceiver(c: Activity, block: () -> Unit): BroadcastReceiver {
        val filter = IntentFilter()
        filter.addAction(COLLECT_RECEIVER)
        val r = ArticleBroadcastReceiver(block)
        LocalBroadcastManager.getInstance(c).registerReceiver(r, filter)
        return r
    }

    fun clearArticleChangesReceiver(c: Activity, r: BroadcastReceiver?) {
        r?.apply {
            LocalBroadcastManager.getInstance(c).unregisterReceiver(this)
        }
    }

}

private class ArticleBroadcastReceiver(val block: () -> Unit) :
    BroadcastReceiver() {

    override fun onReceive(context: Context, intent: Intent) {
        Log.e("TAG", "onReceive: ${intent.action}")
        if (intent.action == ArticleBroadCast.COLLECT_RECEIVER) {
            block.invoke()
        }
    }
}