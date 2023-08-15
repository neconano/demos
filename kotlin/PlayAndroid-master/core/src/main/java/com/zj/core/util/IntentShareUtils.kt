package com.zj.core.util

import android.annotation.SuppressLint
import android.app.Activity
import android.content.Intent
import android.net.Uri

object IntentShareUtils {

    @SuppressLint("QueryPermissionsNeeded")
    fun shareFile(activity: Activity, uri: Uri?, title: String) {
        val intent = Intent(Intent.ACTION_SEND).apply {
            type = "image/*"
            putExtra(Intent.EXTRA_STREAM, uri)
            flags = Intent.FLAG_ACTIVITY_NEW_TASK
        }
        if (intent.resolveActivity(activity.packageManager) != null) {
            activity.startActivity(Intent.createChooser(intent, title))
        }
    }

}