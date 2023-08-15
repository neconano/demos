package com.zj.play.home.almanac

import android.app.Application
import android.net.Uri
import com.zj.core.almanac.CalendarUtils
import com.zj.model.room.PlayDatabase
import com.zj.model.room.entity.Almanac
import dagger.hilt.android.scopes.ActivityRetainedScoped
import java.util.*
import javax.inject.Inject

@ActivityRetainedScoped
class AlmanacRepository @Inject constructor(application: Application) {

    private val almanacDao = PlayDatabase.getDatabase(application).almanacDao()

    /**
    * 访问数据库获得当日黄历图片
    *  */
    suspend fun getAlmanacUri(calendar: Calendar): Uri? {
        val julianDayFromCalendar =
            CalendarUtils.getJulianDayFromCalendar(calendar)
        val almanac = almanacDao.getAlmanac(julianDayFromCalendar)
        return if (almanac?.imgUri != null) {
            Uri.parse(almanac.imgUri)
        } else {
            null
        }
    }

    suspend fun addAlmanac(calendar: Calendar, imgUri: String) {
        almanacDao.insert(
            Almanac(
                julianDay = CalendarUtils.getJulianDayFromCalendar(calendar),
                imgUri = imgUri
            )
        )
    }

}