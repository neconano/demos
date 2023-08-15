package com.smarttoolfactory.tutorial1_1basics.chapter5_gesture

import androidx.compose.foundation.background
import androidx.compose.foundation.gestures.awaitEachGesture
import androidx.compose.foundation.gestures.awaitFirstDown
import androidx.compose.foundation.gestures.calculateCentroid
import androidx.compose.foundation.gestures.calculateCentroidSize
import androidx.compose.foundation.gestures.calculatePan
import androidx.compose.foundation.gestures.calculateRotation
import androidx.compose.foundation.gestures.calculateZoom
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.offset
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clipToBounds
import androidx.compose.ui.draw.drawWithContent
import androidx.compose.ui.geometry.Offset
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.graphicsLayer
import androidx.compose.ui.input.pointer.PointerEvent
import androidx.compose.ui.input.pointer.PointerInputChange
import androidx.compose.ui.input.pointer.pointerInput
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.IntOffset
import androidx.compose.ui.unit.dp
import com.smarttoolfactory.tutorial1_1basics.R
import com.smarttoolfactory.tutorial1_1basics.ui.Blue400
import com.smarttoolfactory.tutorial1_1basics.ui.Green400
import com.smarttoolfactory.tutorial1_1basics.ui.Pink400
import com.smarttoolfactory.tutorial1_1basics.ui.components.StyleableTutorialText
import com.smarttoolfactory.tutorial1_1basics.ui.components.TutorialText2
import kotlin.math.roundToInt

@Preview
@Composable
fun Tutorial5_4Screen3() {
    TutorialContent()
}

@Composable
private fun TutorialContent() {

    Column(
        modifier = Modifier
            .padding(8.dp)
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
    ) {

        StyleableTutorialText(
            text =
            "1-) Use **awaitPointerEventScope** functions to calculate centroid " +
                    "size and position, zoom, pan, and rotation."
        )

        TutorialText2(
            text = "Calculate Centroid",
            modifier = Modifier.padding(top = 8.dp)
        )

        CalculateCentroidExample()

        TutorialText2(
            text = "Calculate Zoom",
            modifier = Modifier.padding(top = 8.dp)
        )
        CalculateZoomExample()

        TutorialText2(
            text = "Calculate Pan",
            modifier = Modifier.padding(top = 20.dp)
        )
        CalculatePanExample()

        TutorialText2(
            text = "Calculate Rotation",
            modifier = Modifier.padding(top = 20.dp)
        )
        CalculateRotationExample()
    }
}

@Composable
private fun CalculateCentroidExample() {

    var centroidSize by remember { mutableStateOf(50f) }
    var position by remember { mutableStateOf(Offset.Zero) }

    var gestureColor by remember { mutableStateOf(Color.LightGray) }

    val pointerModifier = Modifier
        .drawWithContent {
            drawContent()
            // Draw a circle where the gesture is
            drawCircle(Pink400, centroidSize, center = position)
        }
        .pointerInput(Unit) {
            awaitEachGesture {

                // Wait for at least one pointer to press down, and set first contact position
                awaitFirstDown().also {
                    position = it.position
                }

                gestureColor = Blue400

                do {

                    // This PointerEvent contains details including events, id, position and more
                    val event: PointerEvent = awaitPointerEvent()


                    val size: Float = event.calculateCentroidSize()
                    if (size != 0f) {
                        centroidSize = event.calculateCentroidSize()
                    }

                    val centroid: Offset = event.calculateCentroid()
                    if (centroid != Offset.Unspecified) {
                        position = centroid
                    }

                    /*
                            Consumes position change if there is any
                            This stops scrolling if there is one set to any parent Composable
                         */
                    event.changes.forEach { pointerInputChange: PointerInputChange ->
                        pointerInputChange.consume()
                    }

                } while (event.changes.any { it.pressed })

                gestureColor = Green400
            }
        }

    // 🔥 This outer box uses clipToBounds() to clip circle if it's out of box bounds
    Box(
        modifier = Modifier
            .padding(vertical = 8.dp)
            .fillMaxWidth()
            .height(250.dp)
            .clipToBounds()
            .background(gestureColor),
        contentAlignment = Alignment.Center
    ) {
        GestureDisplayBox(
            pointerModifier.matchParentSize(),
            "Use pointers to calculate center of pointers and draw a circle"
        )
    }
}

@Composable
private fun CalculateZoomExample() {
    var zoom by remember { mutableStateOf(1f) }

    var text by remember {
        mutableStateOf(
            "Use pinch gesture to zoom"
        )
    }

    val imageModifier = Modifier
        .graphicsLayer(scaleX = zoom, scaleY = zoom)
        .background(Color.Blue)
        .pointerInput(Unit) {
            awaitEachGesture {
                // Wait for at least one pointer to press down
                awaitFirstDown()
                do {

                    val event = awaitPointerEvent()
                    zoom *= event.calculateZoom()
                    text = "Zoom $zoom"

                    /*
                        Consumes position change if there is any
                        This stops scrolling if there is one set to any parent Composable
                     */
                    event.changes.forEach { pointerInputChange: PointerInputChange ->
                        pointerInputChange.consume()
                    }
                } while (event.changes.any { it.pressed })
            }
        }
        .fillMaxWidth()

    ImageBox(boxModifier, imageModifier, R.drawable.landscape3, text)
}


@Composable
private fun CalculatePanExample() {
    val offsetX = remember { mutableStateOf(0f) }
    val offsetY = remember { mutableStateOf(0f) }

    var text by remember {
        mutableStateOf(
            " Move image with single finger in either x or y coordinates."
        )
    }

    val imageModifier =
        Modifier
            .offset { IntOffset(offsetX.value.roundToInt(), offsetY.value.roundToInt()) }
            .graphicsLayer()
            .background(Color.Blue)
            .pointerInput(Unit) {
                awaitEachGesture {
                    // Wait for at least one pointer to press down
                    awaitFirstDown()

                    do {

                        val event = awaitPointerEvent()
                        val offset = event.calculatePan()
                        offsetX.value += offset.x
                        offsetY.value += offset.y

                        text = "Pan $offset"

                        /*
                                Consumes position change if there is any
                                This stops scrolling if there is one set to any parent Composable
                             */
                        event.changes.forEach { pointerInputChange: PointerInputChange ->
                            pointerInputChange.consume()
                        }
                    } while (event.changes.any { it.pressed })
                }
            }
            .fillMaxWidth()

    ImageBox(boxModifier, imageModifier, R.drawable.landscape1, text, Blue400)
}

@Composable
private fun CalculateRotationExample() {
    var angle by remember { mutableStateOf(0f) }

    var text by remember {
        mutableStateOf("Rotate image using two fingers with twisting gesture.")
    }

    val imageModifier = Modifier
        .graphicsLayer(rotationZ = angle)
        .background(Color.Blue)
        .pointerInput(Unit) {
            awaitEachGesture {

                // Wait for at least one pointer to press down
                awaitFirstDown()

                do {

                    val event = awaitPointerEvent()
                    val rotation = event.calculateRotation()
                    angle += rotation

                    text = "Angle $angle"

                    /*
                            Consumes position change if there is any
                            This stops scrolling if there is one set to any parent Composable
                         */
                    event.changes.forEach { pointerInputChange: PointerInputChange ->
                        pointerInputChange.consume()
                    }

                } while (event.changes.any { it.pressed })
            }
        }
        .fillMaxWidth()

    ImageBox(boxModifier, imageModifier, R.drawable.landscape2, text, Green400)
}
