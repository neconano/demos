package com.smarttoolfactory.tutorial1_1basics.chapter4_state

import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.heightIn
import androidx.compose.foundation.layout.offset
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.Slider
import androidx.compose.material.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.IntOffset
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.smarttoolfactory.tutorial1_1basics.ui.Blue400
import com.smarttoolfactory.tutorial1_1basics.ui.Green400
import com.smarttoolfactory.tutorial1_1basics.ui.Pink400
import com.smarttoolfactory.tutorial1_1basics.ui.Red400
import com.smarttoolfactory.tutorial1_1basics.ui.components.StyleableTutorialText
import com.smarttoolfactory.tutorial1_1basics.ui.components.getRandomColor

/**
 * In this example
 * how changing a state or lambda a Modifier reads effects that Modifier is displayed.
 * Using a lambda instead of value with [Modifier.offset] defers read which ensures it to be
 * not recomposed.
 *
 * Check the [link](https://developer.android.com/jetpack/compose/performance)
 * or next tutorial [Tutorial4_7_1Screen] for Compose phases
 *
 */
@Preview
@Composable
fun Tutorial4_6Screen() {
    TutorialContent()
}

@Composable
private fun TutorialContent() {
    Column(
        modifier = Modifier
            .fillMaxSize()

    ) {

        StyleableTutorialText(
            text = "Changing a state that is read by a **Modifier** triggers " +
                    "that section to be composed." +
                    "For instance if we change state that sets padding for " +
                    "**Modifier.padding().background().size()** " +
                    "only the **PaddingModifier** is changed while Size and Background " +
                    "are the same " +
                    "modifiers from previous recomposition",
            bullets = false
        )
        ModifierRecompositionSample()
    }
}

@Composable
private fun ModifierRecompositionSample() {

    var padding by remember { mutableStateOf(0f) }
    var offsetX by remember { mutableStateOf(0f) }
    var height by remember { mutableStateOf(150f) }

    Text(text = "Padding")
    Slider(value = padding,
        valueRange = 0f..50f,
        onValueChange = {
            padding = it
        }
    )

    Text(text = "OffsetX")
    Slider(value = offsetX,
        valueRange = 0f..50f,
        onValueChange = {
            offsetX = it
        }
    )

    Text(text = "Height")
    Slider(value = height,
        valueRange = 150f..350f,
        onValueChange = {
            height = it
        }
    )

    // This modifier is never recomposed when Column is recomposed(border changes)
    // since it doesn't read any value from any state
    val modifier1 = Modifier
        .fillMaxWidth()
        .heightIn(max = 350.dp)
        .background(Red400)
    // Using new background returns new Modifier because in next recomposition of parent
    // it reads value from getRandomColor() function.
//        .background(getRandomColor())

    val modifier2 = Modifier
        .padding(start = padding.dp)
        .fillMaxWidth()
        .heightIn(max = 350.dp)
        .background(Blue400)
//        .background(getRandomColor())


    val modifier3 = Modifier
        .offset(x = offsetX.dp)
        .fillMaxWidth()
        .height(height.dp)
        .background(Pink400  )
//        .background(getRandomColor())


    val modifier4 = Modifier
        // 🔥 Using a lambda instead of Modifier.offset(x) defers read from Composition
        // phase to Layout phase as described in next tutorial
        .offset {
            // this is only to move same amount as Modifier3, it's not for showing
            // Modifier recomposition
            val newX = offsetX.dp.roundToPx()
            IntOffset(newX, 0)
        }
        .fillMaxWidth()
        .height(height.dp)
        .background(Green400)
//        .background(getRandomColor())

    Column(
        modifier = Modifier
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
            .border(4.dp, getRandomColor())
    ) {

        Box(modifier1) {
            Text(
                text = "modifier1 hash: ${modifier1.hashCode()}\n" +
                        "Modifier: $modifier1",
                color = Color.White,
                fontSize = 12.sp
            )
        }

        Box(modifier2) {
            Text(
                text = "modifier2 hash: ${modifier2.hashCode()}\n" +
                        "Modifier: $modifier2",
                color = Color.White,
                fontSize = 12.sp
            )
        }

        Box(modifier3) {
            Text(
                text = "modifier3 hash: ${modifier3.hashCode()}\n" +
                        "Modifier: $modifier3",
                color = Color.White,
                fontSize = 12.sp
            )
        }

        Box(modifier4) {
            Text(
                text = "modifier4 hash: ${modifier4.hashCode()}\n" +
                        "Modifier: $modifier4",
                color = Color.White,
                fontSize = 12.sp
            )
        }
    }
}
