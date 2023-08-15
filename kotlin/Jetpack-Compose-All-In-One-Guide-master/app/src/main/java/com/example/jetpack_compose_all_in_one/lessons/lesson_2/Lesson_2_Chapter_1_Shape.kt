package com.example.jetpack_compose_all_in_one.lessons.lesson_2


import android.content.res.Configuration
import android.widget.Toast
import androidx.compose.foundation.BorderStroke
import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.CutCornerShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.*
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.RectangleShape
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.tooling.preview.Devices
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.example.jetpack_compose_all_in_one.ui.components.LessonHeader
import com.example.jetpack_compose_all_in_one.ui.components.LessonText2

@Preview()
@Composable
fun Lesson_2_Chapter_Shape() {
    LessonContent()
}

@Composable
private fun LessonContent() {

    LazyColumn(Modifier.fillMaxSize()) {

        item {
            LessonHeader(text = "Clickable")
            LessonText2(
                text = "1-) Adding clickable to Modifier makes a component clickable." +
                        "\nPadding before clickable makes " +
                        "**clickable area smaller than component's total area**."
            )
            ClickableModifierExample()
        }
        item {
            LessonHeader(text = "Surface")
            LessonText2(text = "2-) Surface can clips it's children to selected shape.")
            SurfaceShapeExample()
        }

        item {
            LessonText2(text = "3-) Surface can set Z index and border of it's children.")
            SurfaceZIndexExample()
        }
        item {
            LessonText2(text = "4-) Surface can set content color for Text and Image.")
            SurfaceContentColorExample()
        }
        item {
            LessonText2(
                text = "5-) Components can have offset in both x and y axes. Surface inside" +
                        " another surface gets clipped when it overflows from it's parent."
            )
            SurfaceClickPropagationExample()
        }
    }
}


/**
 * Add **clickable** modifier to components.
 *
 * *Modifier in weight for [Row] determines how much space that child will take.
 * This is same as layout weights in **LinearLayout**.
 *
 * * **Padding** after clickable removes padded area from clickable zone. Click blue
 * rectangle to see the zone.
 */
@Composable
fun ClickableModifierExample() {

    // Provides a Context that can be used by Android applications
    val context = LocalContext.current

    // Weight in Row acts as Weight in LinearLayout with horizontal orientation

    Row(Modifier.height(120.dp)) {

        Column(
            modifier = Modifier
                .weight(1f)
                .fillMaxHeight()
                .background(Color(0xFF388E3C))
                .clickable(onClick = {
                    Toast
                        .makeText(context, "Clicked me", Toast.LENGTH_SHORT)
                        .show()
                }),
            verticalArrangement = Arrangement.Center,
            horizontalAlignment = Alignment.CenterHorizontally
        ) {

            Text(
                color = Color.White,
                fontSize = 24.sp,
                fontWeight = FontWeight.Bold,
                text = "Click Me"
            )
        }

        Column(
            modifier = Modifier
                .weight(1f)
                .fillMaxHeight()
                .background(Color(0xFF1E88E5))
                .padding(15.dp)
                .clickable(onClick = {
                    Toast
                        .makeText(context, "Clicked me", Toast.LENGTH_SHORT)
                        .show()
                }),
            verticalArrangement = Arrangement.Center,
            horizontalAlignment = Alignment.CenterHorizontally
        ) {

            Text(
                color = Color.White,
                fontSize = 24.sp,
                fontWeight = FontWeight.Bold,
                text = "Click Me"
            )
        }
    }
}


/**
 * Surface
 *
 * Material surface is the central metaphor in material design. Each surface exists at a given
 * elevation, which influences how that piece of surface visually relates to other surfaces and
 * how that surface casts shadows.
 *
 * The [Surface] is responsible for:
 *
 * 1) Clipping: Surface clips its children to the shape specified by [shape]
 *
 * 2) Elevation: Surface elevates its children on the Z axis by [elevation] pixels,
 * and draws the appropriate shadow.
 *
 * 3) Borders: If [shape] has a border, then it will also be drawn.
 *
 * 4) Background: Surface fills the shape specified by [shape] with the [color]. If [color] is
 * [Colors.surface], the [ElevationOverlay] from [LocalElevationOverlay] will be used to apply
 * an overlay - by default this will only occur in dark theme. The color of the overlay depends
 * on the [elevation] of this Surface, and the [LocalAbsoluteElevation] set by any parent
 * surfaces. This ensures that a Surface never appears to have a lower elevation overlay than its
 * ancestors, by summing the elevation of all previous Surfaces.
 *
 * 5) Content color: Surface uses [contentColor] to specify a preferred color for the content of
 * this surface - this is used by the [Text] and [Icon] components as a default color.
 */
@Composable
fun SurfaceShapeExample() {

    Row {

        // Set Aspect ratio to 1:1 to have same width and height
        val modifier = Modifier
            .aspectRatio(1f)
            // Weight makes sure that we use the width - total padding space
            // evenly between composables
            .weight(1f)
            .padding(12.dp)


        // Rectangle Shape
        Surface(
            shape = RectangleShape,
            modifier = modifier,
            color = (Color(0xFFFDD835))
        ) {

        }

        // Rounder Corner Shape
        Surface(
            shape = RoundedCornerShape(5.dp),
            modifier = modifier,
            color = (Color(0xFFF4511E))
        ) {}

        // Circle Shape
        Surface(
            shape = CircleShape,
            modifier = modifier,
            color = (Color(0xFF26C6DA))
        ) {}

        //
        Surface(
            shape = CutCornerShape(10.dp),
            modifier = modifier,
            color = (Color(0xFF7E57C2))
        ) {}
    }
}

@Composable
fun SurfaceZIndexExample() {

    Row {

        // Set Aspect ratio to 1:1 to have same width and height
        val modifier = Modifier
            .aspectRatio(1f)
            // Weight makes sure that we use the width - total padding space
            // evenly between composable
            .weight(1f)
            .padding(12.dp)

        // Rectangle Shape
        Surface(
            shape = RectangleShape,
            modifier = modifier,
            color = (Color(0xFFFDD835)),
            elevation = 5.dp,
            border = BorderStroke(5.dp, color = Color(0xFFFF6F00))
        ) {}

        // Rounder Corner Shape
        Surface(
            shape = RoundedCornerShape(5.dp),
            modifier = modifier,
            color = (Color(0xFFF4511E)),
            elevation = 8.dp,
            border = BorderStroke(3.dp, color = Color(0xFF6D4C41))
        ) {}

        // Circle Shape
        Surface(
            shape = CircleShape,
            modifier = modifier,
            color = (Color(0xFF26C6DA)),
            elevation = 11.dp,
            border = BorderStroke(2.dp, color = Color(0xFF004D40))
        ) {}

        // Rectangle with cut corner on top left
        Surface(
            shape = CutCornerShape(topStartPercent = 20),
            modifier = modifier,
            color = (Color(0xFFB2FF59)),
            elevation = 15.dp,
            border = BorderStroke(2.dp, color = Color(0xFFd50000))
        ) {}
    }
}

@Composable
fun SurfaceContentColorExample() {
    // Padding on Surface is padding for background and Text. Padding on Text is padding
    // between font and Surface
    Surface(
        modifier = Modifier.padding(12.dp),
        shape = RoundedCornerShape(10.dp),
        color = (Color(0xFFFDD835)),
        contentColor = (Color(0xFF26C6DA))
    ) {
        Text(
            text = "Text inside Surface uses Surface's content color as a default color.",
            fontWeight = FontWeight.Bold,
            modifier = Modifier.padding(8.dp)
        )
    }
}

@Composable
fun SurfaceClickPropagationExample() {

    // Provides a Context that can be used by Android applications
    val context = LocalContext.current

    // 🔥 Offset moves a component in x and y axes which can be either positive or negative
    // 🔥🔥 When a component inside surface is offset from original position it gets clipped.
    Box(
        modifier = Modifier
            .fillMaxWidth()
            .wrapContentHeight()
            .clickable(onClick = {
                Toast
                    .makeText(context, "Box Clicked", Toast.LENGTH_SHORT)
                    .show()
            })
    ) {

        Surface(
            elevation = 10.dp,
            shape = RoundedCornerShape(10.dp),
            color = (Color(0xFFFDD835)),
            modifier = Modifier
                .size(150.dp)
                .padding(12.dp)
                .clip(RoundedCornerShape(10.dp))
                .clickable(onClick = {
                    Toast
                        .makeText(
                            context,
                            "Surface(Left) inside Box is clicked!",
                            Toast.LENGTH_SHORT
                        )
                        .show()
                })
        ) {

            Surface(
                modifier = Modifier
                    .size(80.dp)
                    .offset(x = 50.dp, y = (-20).dp)
                    .clip(CircleShape)
                    .clickable(onClick = {
                        Toast
                            .makeText(
                                context,
                                "Surface inside Surface is clicked!",
                                Toast.LENGTH_SHORT
                            )
                            .show()
                    }),
                elevation = 12.dp,
                color = (Color(0xFF26C6DA))
            ) {}

        }

        Surface(
            modifier = Modifier
                .size(110.dp)
                .padding(12.dp)
                .offset(x = 110.dp, y = 20.dp)
                .clip(CutCornerShape(10.dp))
                .clickable(onClick = {
                    Toast
                        .makeText(
                            context,
                            "Surface(Right) inside Box is clicked!",
                            Toast.LENGTH_SHORT
                        )
                        .show()

                }),
            color = (Color(0xFFF4511E)),
            elevation = 8.dp
        ) {}
    }
}

@Preview
@Preview("dark", uiMode = Configuration.UI_MODE_NIGHT_YES)
@Preview(device = Devices.PIXEL_C)
@Composable
private fun Lesson2_Preview() {
    LessonContent()
}