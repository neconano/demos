package com.arkivanov.sample.shared

import android.view.Gravity
import android.view.View
import android.view.ViewGroup
import androidx.interpolator.view.animation.FastOutSlowInInterpolator
import androidx.transition.Fade
import androidx.transition.Slide
import androidx.transition.TransitionManager
import androidx.transition.TransitionSet

internal fun ViewGroup.beginDelayedSlideTransition(newView: View, oldView: View, isForward: Boolean) {
    TransitionManager.beginDelayedTransition(
        this,
        TransitionSet()
            .addTransition(Slide(if (isForward) Gravity.END else Gravity.START).addTarget(newView))
            .addTransition(Slide(if (isForward) Gravity.START else Gravity.END).addTarget(oldView))
            .setInterpolator(FastOutSlowInInterpolator()),
    )
}

internal fun ViewGroup.beginDelayedSlideFadeTransition(newView: View, oldView: View, isForward: Boolean) {
    TransitionManager.beginDelayedTransition(
        this,
        TransitionSet()
            .addTransition(Slide(Gravity.END).addTarget(if (isForward) newView else oldView))
            .addTransition(Fade(Fade.MODE_IN).addTarget(newView))
            .addTransition(Fade(Fade.MODE_OUT).addTarget(oldView))
            .setInterpolator(FastOutSlowInInterpolator()),
    )
}
