package com.zj.play.main.login

import com.zj.network.base.PlayAndroidNetwork
import com.zj.play.base.liveDataModel
import dagger.hilt.android.scopes.ActivityRetainedScoped
import javax.inject.Inject

@ActivityRetainedScoped
class AccountRepository @Inject constructor() {

    suspend fun getLogin(username: String, password: String) =
        PlayAndroidNetwork.getLogin(username, password)

    suspend fun getRegister(username: String, password: String, repassword: String) =
        PlayAndroidNetwork.getRegister(username, password, repassword)

    fun getLogout() = liveDataModel { PlayAndroidNetwork.getLogout() }

}