package com.example.jetpack_compose_all_in_one.application_components.services.music_example

import android.app.Service
import android.content.Intent
import android.media.MediaPlayer
import android.net.Uri
import android.os.Binder
import android.provider.Settings
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.Job
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

class MusicBoundService: Service() {

    private val mediaPlayer by lazy {
        MediaPlayer.create(this, Settings.System.DEFAULT_RINGTONE_URI).apply {
            setOnCompletionListener { stopSelf() }
        }
    }

    private val binder = RemoteControl()
    private var pauseJob: Job? = null

    inner class RemoteControl: Binder() {
        val service get() = this@MusicBoundService
    }

    override fun onBind(p0: Intent?) = binder

    override fun onDestroy() {
        super.onDestroy()
        mediaPlayer.release()
    }

    fun startMusic(musicUri: Uri) {
        mediaPlayer.apply {
            reset()
            setDataSource(this@MusicBoundService, musicUri)
            prepare()
            start()
        }
    }

    fun stopMusic() {
        mediaPlayer.stop()
    }

    fun pauseMusic(duration: Long? = null) {
        pauseJob?.cancel()
        pauseJob = null

        pauseJob = CoroutineScope(Dispatchers.Default + Job()).launch {
            mediaPlayer.pause()
            duration?.let {
                delay(it)
                resumeMusic()
            }
        }
    }

    fun resumeMusic() {
        mediaPlayer.start()
        pauseJob?.cancel()
        pauseJob = null
    }
}