package com.example.jetpack_compose_all_in_one.application_components.broadcastreceiver.wifi

import android.content.BroadcastReceiver
import android.content.Context
import android.content.Intent
import android.net.wifi.WifiManager
import android.util.Log


class WifiReceiver : BroadcastReceiver() {
    override fun onReceive(context: Context?, intent: Intent?) {
        intent?.let {
            when (it.action) {
                WifiManager.WIFI_STATE_CHANGED_ACTION -> {
                    val connectionState =
                        it.getIntExtra(WifiManager.EXTRA_WIFI_STATE, WifiManager.WIFI_STATE_UNKNOWN)
                    if (context != null) {
                        handleConnectionState(connectionState)
                    }
                }
            }
        }
    }

    private fun handleConnectionState(connectionState: Int) {
        when (connectionState) {
            WifiManager.WIFI_STATE_ENABLING -> {
                Log.i("Wifi", "Wifi is Enabling")
            }

            WifiManager.WIFI_STATE_ENABLED -> {
                Log.i("Wifi", "Wifi is Enabled")
            }

            WifiManager.WIFI_STATE_DISABLED -> {
                Log.i("Wifi", "Wifi is Disabled")
            }

            WifiManager.WIFI_STATE_DISABLING -> {
                Log.i("Wifi", "Wifi is Disabling")
            }

            else ->
                Log.i("Wifi", "Wifi is Unknown")
        }
    }
}