package com.example.jetpack_compose_all_in_one.ui.views.chat

import androidx.compose.runtime.Stable
import androidx.compose.ui.Modifier
import androidx.compose.ui.layout.LayoutModifier
import androidx.compose.ui.layout.Measurable
import androidx.compose.ui.layout.MeasureResult
import androidx.compose.ui.layout.MeasureScope
import androidx.compose.ui.unit.Constraints
import androidx.compose.ui.unit.Dp
import androidx.compose.ui.unit.constrainHeight
import androidx.compose.ui.unit.constrainWidth
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.offset

/*
    These padding samples are to show how Constraints.offset or
    Constraints.constrainWidth/Height effect placeable placing when Composable dimensions are
    bigger than parent Composable dimensions.
 */

/**
 * This modifier is similar to **padding** modifier. Uses Constraints.offset() to measure placeable
 * without the area reserved for padding. When size of the Composable is bigger than parent
 * Composable offset limits area to placeable width + horizontal padding when setting width
 */
@Stable
fun Modifier.customPaddingWithOffsetAndConstrain(all: Dp) =
    this.then(
        PaddingModifierWithOffsetAndConstrain(
            start = all,
            top = all,
            end = all,
            bottom = all,
            rtlAware = true
        )
    )

// Implementation detail
private class PaddingModifierWithOffsetAndConstrain(
    val start: Dp = 0.dp,
    val top: Dp = 0.dp,
    val end: Dp = 0.dp,
    val bottom: Dp = 0.dp,
    val rtlAware: Boolean,
) : LayoutModifier {

    override fun MeasureScope.measure(
        measurable: Measurable,
        constraints: Constraints
    ): MeasureResult {

        val horizontal = start.roundToPx() + end.roundToPx()
        val vertical = top.roundToPx() + bottom.roundToPx()

        val placeable = measurable.measure(constraints.offset(-horizontal, -vertical))

        val width = constraints.constrainWidth(placeable.width + horizontal)
        val height = constraints.constrainHeight(placeable.height + vertical)

        println(
            "😁 PaddingModifier() " +
                    "horizontal: $horizontal, " +
                    "vertical: $vertical, placeable width: ${placeable.width}"
        )

        return layout(width, height) {
            if (rtlAware) {
                placeable.placeRelative(start.roundToPx(), top.roundToPx())
            } else {
                placeable.place(start.roundToPx(), top.roundToPx())
            }
        }
    }
}


/**
 * This modifier is similar to **padding** modifier but
 * `measurable.measure(constraint)` used instead of
 * `measurable.measure(constraints.offset(-horizontal, -vertical))`.
 * offset only reserves area after padding is applied. With this modifier if parent dimensions
 * are bigger we break padding.
 *
 * ## Note
 * This is for demonstration only. Use offset when placing placeables with some rules requires
 *  offset to limit placeable size considering padding size
 *
 */
@Stable
fun Modifier.customPaddingWithConstrainOnly(all: Dp) =
    this.then(
        PaddingModifierWithoutOffset(
            start = all,
            top = all,
            end = all,
            bottom = all,
            rtlAware = true
        )
    )

// Implementation detail
private class PaddingModifierWithoutOffset(
    val start: Dp = 0.dp,
    val top: Dp = 0.dp,
    val end: Dp = 0.dp,
    val bottom: Dp = 0.dp,
    val rtlAware: Boolean,
) : LayoutModifier {

    override fun MeasureScope.measure(
        measurable: Measurable,
        constraints: Constraints
    ): MeasureResult {

        val horizontal = start.roundToPx() + end.roundToPx()
        val vertical = top.roundToPx() + bottom.roundToPx()

        val placeable = measurable.measure(constraints)

        val width = constraints.constrainWidth(placeable.width + horizontal)
        val height = constraints.constrainHeight(placeable.height + vertical)

        println(
            "🤡 PaddingModifierWithoutOffset() " +
                    "horizontal: $horizontal, " +
                    "vertical: $vertical, placeable width: ${placeable.width}"
        )

        return layout(width, height) {
            if (rtlAware) {
                placeable.placeRelative(start.roundToPx(), top.roundToPx())
            } else {
                placeable.place(start.roundToPx(), top.roundToPx())
            }
        }
    }
}

@Stable
fun Modifier.customPadding(all: Dp) =
    this.then(
        PaddingModifier(
            start = all,
            top = all,
            end = all,
            bottom = all,
            rtlAware = true
        )
    )

// Implementation detail
private class PaddingModifier(
    val start: Dp = 0.dp,
    val top: Dp = 0.dp,
    val end: Dp = 0.dp,
    val bottom: Dp = 0.dp,
    val rtlAware: Boolean,
) : LayoutModifier {

    override fun MeasureScope.measure(
        measurable: Measurable,
        constraints: Constraints
    ): MeasureResult {

        val horizontal = start.roundToPx() + end.roundToPx()
        val vertical = top.roundToPx() + bottom.roundToPx()

        val placeable = measurable.measure(constraints)

        val width = (placeable.width + horizontal)
        val height = (placeable.height + vertical)

        println(
            "😍 PaddingModifier() " +
                    "horizontal: $horizontal, " +
                    "vertical: $vertical, placeable width: ${placeable.width}"
        )

        return layout(width, height) {
            if (rtlAware) {
                placeable.placeRelative(start.roundToPx(), top.roundToPx())
            } else {
                placeable.place(start.roundToPx(), top.roundToPx())
            }
        }
    }
}