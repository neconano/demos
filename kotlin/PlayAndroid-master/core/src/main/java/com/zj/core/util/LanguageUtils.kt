package com.zj.core.almanac

import java.util.*

fun isZhLanguage(): Boolean {
    return Locale.getDefault().language == "zh"
}