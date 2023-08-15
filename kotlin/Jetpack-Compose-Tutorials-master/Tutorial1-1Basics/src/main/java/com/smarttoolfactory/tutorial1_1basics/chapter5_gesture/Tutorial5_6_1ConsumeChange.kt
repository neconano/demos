package com.smarttoolfactory.tutorial1_1basics.chapter5_gesture

import android.widget.Toast
import androidx.compose.foundation.background
import androidx.compose.foundation.gestures.awaitDragOrCancellation
import androidx.compose.foundation.gestures.awaitEachGesture
import androidx.compose.foundation.gestures.awaitFirstDown
import androidx.compose.foundation.gestures.awaitTouchSlopOrCancellation
import androidx.compose.foundation.gestures.waitForUpOrCancellation
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.shadow
import androidx.compose.ui.geometry.Offset
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.input.pointer.PointerEvent
import androidx.compose.ui.input.pointer.PointerInputChange
import androidx.compose.ui.input.pointer.changedToDown
import androidx.compose.ui.input.pointer.changedToDownIgnoreConsumed
import androidx.compose.ui.input.pointer.changedToUp
import androidx.compose.ui.input.pointer.changedToUpIgnoreConsumed
import androidx.compose.ui.input.pointer.pointerInput
import androidx.compose.ui.input.pointer.positionChange
import androidx.compose.ui.input.pointer.positionChanged
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import com.smarttoolfactory.tutorial1_1basics.ui.Blue400
import com.smarttoolfactory.tutorial1_1basics.ui.BlueGrey400
import com.smarttoolfactory.tutorial1_1basics.ui.Brown400
import com.smarttoolfactory.tutorial1_1basics.ui.Green400
import com.smarttoolfactory.tutorial1_1basics.ui.Orange400
import com.smarttoolfactory.tutorial1_1basics.ui.Red400
import com.smarttoolfactory.tutorial1_1basics.ui.backgroundColor
import com.smarttoolfactory.tutorial1_1basics.ui.components.StyleableTutorialText

/**
 * This tutorial is about consuming in down, move, or up  and results of consuming changes.
 *
 * **awaitFirstDown** is the first touch event, consuming down
 * results [PointerInputChange.changedToDown] false, but [PointerInputChange.changedToDownIgnoreConsumed]
 * since it only cares about down event
 *
 * *Consuming an event is done with [PointerInputChange.consume]

 * *Consuming position change results
 * [PointerInputChange.positionChanged] to return false and [PointerInputChange.positionChange]
 * return [Offset.Zero]. Also consuming prevents event like scrolling or
 * dragging to commence
 *
 */
@Preview
@Composable
fun Tutorial5_6Screen1() {
    TutorialContent()
}

@Composable
private fun TutorialContent() {

    Column(
        modifier = Modifier
            .fillMaxSize()
            .background(backgroundColor)
            .verticalScroll(rememberScrollState())
    ) {

        StyleableTutorialText(
            text = "1-) consume after **awaitFirstDown** or **waitForUpOrCancellation** " +
                    "observe outcomes of **PointerInputChange** functions"
        )
        ConsumeDownAndUpEventsExample()
        ConsumeDownAndMoveEventsExample()
        ConsumeDragEventsExample()
    }

}

@Composable
private fun ConsumeDownAndUpEventsExample() {

    // color and text are for debugging and observing state changes and position
    var gestureColor by remember { mutableStateOf(Color.White) }
    // This text is drawn to Text composable
    var gestureText by remember { mutableStateOf("") }

    val pointerModifier = gestureModifier
        .background(gestureColor)
        .pointerInput(Unit) {
            awaitEachGesture {
                // Wait for at least one pointer to press down, and set first contact position
                val down: PointerInputChange = awaitFirstDown()

                gestureColor = Orange400

                // Consuming down causes changeToDown to return false
                // And other events like scroll to not interfere with this event
                down.consume()

                var eventChanges: String = "🎃DOWN\n" +
                        "changedToDown: ${down.changedToDown()}, " +
                        "changedToDownIgnoreConsumed: ${down.changedToDownIgnoreConsumed()}\n" +
                        "pressed: ${down.pressed}\n" +
                        "changedUp: ${down.changedToUp()}\n" +
                        "positionChanged: ${down.positionChanged()}\n" +
                        "isConsumed: ${down.isConsumed}\n"

                gestureText = eventChanges

                // 🔥 Wait for Up Event, this is called if only one pointer exits
                // when it's up or moved out of Composable bounds
                // When multiple pointers touch Composable it requires only one to be
                // out of Composable bounds
                val upOrCancel: PointerInputChange? = waitForUpOrCancellation()

                if (upOrCancel != null) {

                    eventChanges +=
                        "🍒UP\n" +
                                "changedToDown: ${upOrCancel.changedToDown()}, " +
                                "changedToDownIgnoreConsumed: ${upOrCancel.changedToDownIgnoreConsumed()}\n" +
                                "pressed: ${upOrCancel.pressed}\n" +
                                "changedUp: ${upOrCancel.changedToUp()}\n" +
                                "changedToUpIgnoreConsumed: ${upOrCancel.changedToUpIgnoreConsumed()}\n" +
                                "isConsumed: ${upOrCancel.isConsumed}\n"
                    gestureColor = Green400
                } else {
                    eventChanges += "UP CANCEL"
                    gestureColor = Red400
                }

                gestureText = eventChanges
            }
        }

    Box(modifier = pointerModifier, contentAlignment = Alignment.Center) {
        Text(
            text = "Touch Here\nto display down or up consume events",
            textAlign = TextAlign.Center
        )
    }

    GestureDisplayBox(
        modifier = gestureTextModifier.verticalScroll(rememberScrollState()),
        gestureText = gestureText
    )
}

@Composable
private fun ConsumeDownAndMoveEventsExample() {

    val context = LocalContext.current

    // color and text are for debugging and observing state changes and position
    var gestureColor by remember { mutableStateOf(Color.White) }
    // This text is drawn to Text composable
    var gestureText by remember { mutableStateOf("") }

    val pointerModifier = gestureModifier
        .background(gestureColor)
        .pointerInput(Unit) {
            awaitEachGesture {

                // Wait for at least one pointer to press down, and set first contact position
                val down: PointerInputChange = awaitFirstDown()

                gestureColor = Orange400

                // Consuming down causes changeToDown to return false
                // And other events like scroll to not interfere with this event
                down.consume()

                var eventChanges: String = "🎃DOWN id: ${down.id.value}\n" +
                        "changedToDown: ${down.changedToDown()}, " +
                        "changedToDownIgnoreConsumed: ${down.changedToDownIgnoreConsumed()}\n" +
                        "pressed: ${down.pressed}\n" +
                        "changedUp: ${down.changedToUp()}\n" +
                        "positionChanged: ${down.positionChanged()}\n" +
                        "isConsumed: ${down.isConsumed}\n"

                do {

                    // This PointerEvent contains details including events, id, position and more
                    val event: PointerEvent = awaitPointerEvent()

                    eventChanges +=
                        "\n🍏MOVE changes size ${event.changes.size}\n"
                    gestureText = eventChanges

                    event.changes
                        .forEachIndexed { index: Int, pointerInputChange: PointerInputChange ->
                            pointerInputChange.consume()

                            eventChanges +=
                                "Index: " +
                                        "$index, id: ${pointerInputChange.id}, " +
                                        "pressed: ${pointerInputChange.pressed}\n" +
                                        "changedUp: ${pointerInputChange.changedToUp()}\n" +
                                        "changedToUpIgnoreConsumed: ${pointerInputChange.changedToUpIgnoreConsumed()}\n" +
                                        "position: ${pointerInputChange.position}\n" +
                                        "positionChange: ${pointerInputChange.positionChange()}\n" +
                                        "positionChanged: ${pointerInputChange.positionChanged()}\n" +
                                        "isConsumed: ${pointerInputChange.isConsumed}\n"
                            gestureText = eventChanges


                            // 🔥 calling consume() sets
                            // positionChange() to Offset(0.0,0.0),
                            // positionChanged() to false,
                            // positionChangeConsumed() to true.
                            // And any parent or pointerInput above this gets no position change
                            // Scrolling or detectGestures check positionChangeConsumed()

                        }

                    gestureColor = Blue400

                } while (
                    event.changes.any {

                        // 🔥 Gets called when a pointer is up
                        if (!it.pressed) {

                            // consume()(UP here) causes changedToUp to return false
                            it.consume()

                            eventChanges +=
                                "\n🚀 POINTER UP id: ${down.id.value}\n" +
                                        "changedToDown: ${it.changedToDown()}, " +
                                        "changedToDownIgnoreConsumed: ${it.changedToDownIgnoreConsumed()}\n" +
                                        "changedUp: ${it.changedToUp()}\n" +
                                        "changedToUpIgnoreConsumed: ${it.changedToUpIgnoreConsumed()}\n" +
                                        "positionChanged: ${it.positionChanged()}\n" +
                                        "isConsumed: ${it.isConsumed}\n"

                            gestureText = eventChanges

                            Toast
                                .makeText(
                                    context,
                                    "🚀 POINTER UP id: ${down.id.value}\n" +
                                            "changedToDown: ${it.changedToDown()}, " +
                                            "changedToDownIgnoreConsumed: ${it.changedToDownIgnoreConsumed()}\n" +
                                            "changedUp: ${it.changedToUp()}\n" +
                                            "changedToUpIgnoreConsumed: ${it.changedToUpIgnoreConsumed()}\n" +
                                            "positionChanged: ${it.positionChanged()}\n" +
                                            "isConsumed: ${it.isConsumed}\n",
                                    Toast.LENGTH_SHORT
                                )
                                .show()


                        }
                        it.pressed
                    }
                )

                gestureColor = Green400
            }
        }

    Box(modifier = pointerModifier, contentAlignment = Alignment.Center) {
        Text(
            text = "Touch Here\nto display down or move consume events",
            textAlign = TextAlign.Center
        )
    }

    GestureDisplayBox(
        modifier = gestureTextModifier.verticalScroll(rememberScrollState()),
        gestureText = gestureText
    )
}

@Composable
private fun ConsumeDragEventsExample() {

    // color and text are for debugging and observing state changes and position
    var gestureColor by remember { mutableStateOf(Color.White) }
    // This text is drawn to Text composable
    var gestureText by remember { mutableStateOf("") }

    val pointerModifier = gestureModifier
        .background(gestureColor)
        .pointerInput(Unit) {
            awaitEachGesture {

                val down: PointerInputChange = awaitFirstDown().also {
                    gestureColor = Orange400
                }

                // Consuming down causes changeToDown to return false
                // And other events like scroll to not interfere with this event
                down.consume()

                var eventChanges =
                    "🎃DOWN\n" +
                            "changedToDown: ${down.changedToDown()}, " +
                            "changedToDownIgnoreConsumed: ${down.changedToDownIgnoreConsumed()}\n" +
                            "pressed: ${down.pressed}\n" +
                            "changedUp: ${down.changedToUp()}\n" +
                            "changedToUpIgnoreConsumed: ${down.changedToUpIgnoreConsumed()}\n" +
                            "positionChanged: ${down.positionChanged()}\n" +
                            "positionChangeConsumed: ${down.isConsumed}\n"

                gestureText = eventChanges


                // 🔥 Waits for drag threshold to be passed by pointer
                // or it returns null if up event is triggered
                var change: PointerInputChange? =
                    awaitTouchSlopOrCancellation(down.id) { change: PointerInputChange, over: Offset ->


                        // 🔥🔥 If consume() is not called drag does not
                        // function properly.
                        // Consuming position change causes
                        // change.positionChanged() to return false.
                        change.consume()
                        eventChanges +=
                            "⛺️ awaitTouchSlopOrCancellation()\n" +
                                    "down.id: ${down.id} change.id: ${change.id}\n" +
                                    "changedToDown: ${change.changedToDown()}\n" +
                                    "changedToDownIgnoreConsumed: ${change.changedToDownIgnoreConsumed()}\n" +
                                    "pressed: ${change.pressed}\n" +
                                    "changedUp: ${change.changedToUp()}\n" +
                                    "changedToUpIgnoreConsumed: ${change.changedToUpIgnoreConsumed()}\n" +
                                    "positionChanged: ${change.positionChanged()}\n" +
                                    "positionChangeConsumed: ${change.isConsumed}\n"

                        gestureColor = Brown400
                        gestureText = eventChanges
                    }


                if (change == null) {
                    gestureColor = Red400
                    gestureText += "awaitTouchSlopOrCancellation() is NULL"
                } else {

                    while (change != null && change.pressed) {

                        // 🔥 Calls awaitPointerEvent() in a while loop and checks drag change
                        change = awaitDragOrCancellation(change.id)

                        if (change != null && change.pressed) {

                            gestureColor = Blue400

                            // 🔥 Consuming position change causes
                            // change.positionChanged() to return false.
                            change.consume()

                            eventChanges +=
                                "🚌 awaitDragOrCancellation()  " +
                                        "down.id: ${down.id} change.id: ${change.id}\n" +
                                        "changedToDown: ${change.changedToDown()}\n" +
                                        "changedToDownIgnoreConsumed: ${change.changedToDownIgnoreConsumed()}\n" +
                                        "pressed: ${change.pressed}\n" +
                                        "changedUp: ${change.changedToUp()}\n" +
                                        "changedToUpIgnoreConsumed: ${change.changedToUpIgnoreConsumed()}\n" +
                                        "position: ${change.position}\n" +
                                        "positionChange: ${change.positionChange()}\n" +
                                        "positionChanged: ${change.positionChanged()}\n" +
                                        "isConsumed: ${change.isConsumed}\n"
                        }
                    }

                    gestureText = eventChanges
                    gestureColor = Green400
                }
            }
        }

    Box(modifier = pointerModifier, contentAlignment = Alignment.Center) {
        Text(text = "Touch Here\nto display drag consume events", textAlign = TextAlign.Center)
    }

    GestureDisplayBox(
        modifier = gestureTextModifier.verticalScroll(rememberScrollState()),
        gestureText = gestureText
    )

}

private val gestureModifier = Modifier
    .padding(vertical = 12.dp, horizontal = 12.dp)
    .fillMaxWidth()
    .height(90.dp)

private val gestureTextModifier = Modifier
    .padding(8.dp)
    .shadow(1.dp)
    .fillMaxWidth()
    .background(BlueGrey400)
    .height(200.dp)
    .padding(2.dp)