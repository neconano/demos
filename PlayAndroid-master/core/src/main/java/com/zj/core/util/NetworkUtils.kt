package com.zj.core.util

import android.annotation.SuppressLint
import android.content.Context
import android.net.ConnectivityManager
import android.net.NetworkCapabilities
import android.util.Log


/**
 * 检查网络可用
 */
@SuppressLint("MissingPermission")
fun Context?.checkNetworkAvailable(): Boolean {
    if (this == null) return true
    val connectivityManager =
        getSystemService(Context.CONNECTIVITY_SERVICE) as ConnectivityManager?
    val network = connectivityManager?.activeNetwork
    return if (network == null) {
        Log.w("checkNetworkAvailable", "Now no network")
        false
    } else {
        val networkCapabilities = connectivityManager.getNetworkCapabilities(network)
        if (networkCapabilities?.hasTransport(NetworkCapabilities.TRANSPORT_CELLULAR) != false) {
            Log.w("checkNetworkAvailable", "Now is cellular")
        }
        if (networkCapabilities?.hasTransport(NetworkCapabilities.TRANSPORT_WIFI) != false) {
            Log.w("checkNetworkAvailable", "Now is WIFI")
        }
        true
    }
}