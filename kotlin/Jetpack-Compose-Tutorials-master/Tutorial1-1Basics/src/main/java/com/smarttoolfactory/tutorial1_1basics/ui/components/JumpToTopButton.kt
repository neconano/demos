package com.smarttoolfactory.tutorial1_1basics.ui.components

import android.content.res.Configuration
import androidx.compose.animation.core.animateDp
import androidx.compose.animation.core.updateTransition
import androidx.compose.foundation.layout.navigationBarsPadding
import androidx.compose.foundation.layout.offset
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.material.FloatingActionButton
import androidx.compose.material.FloatingActionButtonDefaults
import androidx.compose.material.Icon
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.ArrowUpward
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.tooling.preview.Devices
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp

private enum class Visibility {
    VISIBLE,
    GONE
}

/**
 * Shows a button that lets the user scroll to the top.
 */
@Composable
fun JumpToTopButton(
    enabled: Boolean,
    onClicked: () -> Unit,
    modifier: Modifier = Modifier
) {
    // Show Jump to Bottom button
    val transition = updateTransition(
        if (enabled) Visibility.VISIBLE else Visibility.GONE,
        label = "jump transition"
    )
    val bottomOffset by transition.animateDp(label = "bottom offset") {
        if (it == Visibility.GONE) {
            (-28).dp
        } else {
            28.dp
        }
    }
    if (bottomOffset > 0.dp) {

        FloatingActionButton(
            elevation = FloatingActionButtonDefaults.elevation(
                defaultElevation = 4.dp,
                pressedElevation = 8.dp
            ),
            backgroundColor = Color(0xffF06292),
            modifier = modifier
                .padding(end = 10.dp)
                .size(48.dp)
                .navigationBarsPadding()
                .offset(x = 0.dp, y = -bottomOffset),
            onClick = onClicked
        ) {
            Icon(
                imageVector = Icons.Filled.ArrowUpward,
                contentDescription = null,
                tint = Color.White
            )
        }
    }
}

@Preview
@Preview("dark", uiMode = Configuration.UI_MODE_NIGHT_YES)
@Preview(device = Devices.PIXEL_C)
@Composable
fun JumpToBottomPreview() {
    JumpToTopButton(enabled = true, onClicked = {})
}
