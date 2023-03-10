package com.example.network

import android.Manifest
import android.content.pm.PackageManager
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import com.example.network.util.PermissionUtil

import kotlinx.android.synthetic.main.activity_main.*
import org.jetbrains.anko.startActivity
import org.jetbrains.anko.toast

/**
 * Created by ouyangshen on 2017/9/24.
 */
class MainActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        btn_message.setOnClickListener { startActivity<MessageActivity>() }
        btn_progress_dialog.setOnClickListener { startActivity<ProgressDialogActivity>() }
        btn_progress_circle.setOnClickListener { startActivity<ProgressCircleActivity>() }
        btn_async_task.setOnClickListener { startActivity<AsyncTaskActivity>() }
        btn_json_parse.setOnClickListener { startActivity<JsonParseActivity>() }
        btn_json_convert.setOnClickListener { startActivity<JsonConvertActivity>() }
        btn_http_request.setOnClickListener {
            if (PermissionUtil.checkPermission(this, Manifest.permission.ACCESS_FINE_LOCATION, R.id.btn_http_request%4096)) {
                startActivity<HttpRequestActivity>()
            }
        }
        btn_http_image.setOnClickListener { startActivity<HttpImageActivity>() }
        btn_download_apk.setOnClickListener { startActivity<DownloadApkActivity>() }
        btn_download_image.setOnClickListener { startActivity<DownloadImageActivity>() }
        btn_content_provider.setOnClickListener { startActivity<ContentProviderActivity>() }
        btn_content_resolver.setOnClickListener {
            if (PermissionUtil.checkMultiPermission(this, arrayOf(Manifest.permission.READ_CONTACTS,
                    Manifest.permission.WRITE_CONTACTS), R.id.btn_content_resolver % 4096)) {
                startActivity<ContentResolverActivity>()
            }
        }
        btn_content_observer.setOnClickListener { startActivity<ContentObserverActivity>() }
        btn_spannable.setOnClickListener { startActivity<SpannableActivity>() }
        btn_auto_update.setOnClickListener {
            if (PermissionUtil.checkPermission(this, Manifest.permission.WRITE_EXTERNAL_STORAGE, R.id.btn_auto_update%4096)) {
                startActivity<AutoUpdateActivity>()
            }
        }
    }

    override fun onRequestPermissionsResult(requestCode: Int, permissions: Array<String>, grantResults: IntArray) {
        if (requestCode == R.id.btn_http_request%4096) {
            if (grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                startActivity<HttpRequestActivity>()
            } else {
                toast("???????????????????????????????????????????????????")
            }
        } else if (requestCode == R.id.btn_content_resolver%4096) {
            if (grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                startActivity<ContentResolverActivity>()
            } else {
                toast("???????????????????????????????????????????????????")
            }
        } else if (requestCode == R.id.btn_auto_update%4096) {
            if (grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                startActivity<AutoUpdateActivity>()
            } else {
                toast("????????????SD????????????????????????????????????")
            }
        }
    }

}
