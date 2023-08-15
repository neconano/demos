package com.smarttoolfactory.tutorial1_1basics.chapter6_graphics

import androidx.compose.ui.geometry.Offset
import androidx.compose.ui.geometry.Rect
import androidx.compose.ui.geometry.Size
import androidx.compose.ui.graphics.Path
import kotlin.math.cos
import kotlin.math.sin


/**
 * Creates a polygon with number of [sides] centered at ([cx],[cy]) with [radius].
 * ```
 *  To generate regular polygons (i.e. where each interior angle is the same),
 *  polar coordinates are extremely useful. You can calculate the angle necessary
 *  to produce the desired number of sides (as the interior angles total 360º)
 *  and then use multiples of this angle with the same radius to describe each point.
 * val x = radius * Math.cos(angle);
 * val y = radius * Math.sin(angle);
 *
 * For instance to draw triangle loop thrice with angle
 * 0, 120, 240 degrees in radians and draw lines from each coordinate.
 * ```
 */
fun createPolygonPath(cx: Float, cy: Float, sides: Int, radius: Float): Path {
    val angle = 2.0 * Math.PI / sides

    return Path().apply {
        moveTo(
            cx + (radius * cos(0.0)).toFloat(),
            cy + (radius * sin(0.0)).toFloat()
        )
        for (i in 1 until sides) {
            lineTo(
                cx + (radius * cos(angle * i)).toFloat(),
                cy + (radius * sin(angle * i)).toFloat()
            )
        }
        close()
    }
}

fun roundedRectanglePath(
    topLeft: Offset = Offset.Zero,
    size: Size,
    cornerRadius: Float
): Path {
    return roundedRectanglePath(
        topLeft = topLeft,
        size = size,
        radiusTopLeft = cornerRadius,
        radiusTopRight = cornerRadius,
        radiusBottomRight = cornerRadius,
        radiusBottomLeft = cornerRadius
    )
}

fun roundedRectanglePath(
    topLeft: Offset = Offset.Zero,
    size: Size,
    radiusTopLeft: Float,
    radiusTopRight: Float,
    radiusBottomRight: Float,
    radiusBottomLeft: Float
): Path {
    return Path().apply {
        reset()

        addRoundedRect(
            radiusTopLeft = radiusTopLeft,
            radiusTopRight = radiusTopRight,
            radiusBottomRight = radiusBottomRight,
            radiusBottomLeft = radiusBottomLeft,
            topLeft = topLeft,
            size = size
        )
    }
}

private fun Path.addRoundedRect(
    radiusTopLeft: Float,
    radiusTopRight: Float,
    radiusBottomRight: Float,
    radiusBottomLeft: Float,
    topLeft: Offset,
    size: Size
) {
    val topLeftRadius = radiusTopLeft * 2
    val topRightRadius = radiusTopRight * 2
    val bottomRightRadius = radiusBottomRight * 2
    val bottomLeftRadius = radiusBottomLeft * 2

    // Top left arc
    arcTo(
        rect = Rect(
            left = topLeft.x,
            top = topLeft.y,
            right = topLeft.x + topLeftRadius,
            bottom = topLeft.y + topLeftRadius
        ),
        startAngleDegrees = 180.0f,
        sweepAngleDegrees = 90.0f,
        forceMoveTo = false
    )

    lineTo(x = topLeft.x + size.width - topRightRadius, y = topLeft.y)

    // Top right arc
    arcTo(
        rect = Rect(
            left = topLeft.x + size.width - topRightRadius,
            top = topLeft.y,
            right = topLeft.x + size.width,
            bottom = topLeft.y + topRightRadius
        ),
        startAngleDegrees = -90.0f,
        sweepAngleDegrees = 90.0f,
        forceMoveTo = false
    )

    lineTo(x = topLeft.x + size.width, y = topLeft.y + size.height - bottomRightRadius)

    // Bottom right arc
    arcTo(
        rect = Rect(
            left = topLeft.x + size.width - bottomRightRadius,
            top = topLeft.y + size.height - bottomRightRadius,
            right = topLeft.x + size.width,
            bottom = topLeft.y + size.height
        ),
        startAngleDegrees = 0f,
        sweepAngleDegrees = 90.0f,
        forceMoveTo = false
    )

    lineTo(x = topLeft.x + bottomLeftRadius, y = topLeft.y + size.height)

    // Bottom left arc
    arcTo(
        rect = Rect(
            left = topLeft.x,
            top = topLeft.y + size.height - bottomLeftRadius,
            right = topLeft.x + bottomLeftRadius,
            bottom = topLeft.y + size.height
        ),
        startAngleDegrees = 90.0f,
        sweepAngleDegrees = 90.0f,
        forceMoveTo = false
    )

    lineTo(x = topLeft.x, y = topLeft.y + topLeftRadius)
    close()
}

/**
 * Create a ticket path with given size and corner radius in px with offset [topLeft].
 *
 * Refer [this link](https://juliensalvi.medium.com/custom-shape-with-jetpack-compose-1cb48a991d42)
 * for implementation details.
 */
fun ticketPath(topLeft: Offset = Offset.Zero, size: Size, cornerRadius: Float): Path {
    return Path().apply {
        reset()
        // Top left arc
        arcTo(
            rect = Rect(
                left = topLeft.x + -cornerRadius,
                top = topLeft.y + -cornerRadius,
                right = topLeft.x + cornerRadius,
                bottom = topLeft.y + cornerRadius
            ),
            startAngleDegrees = 90.0f,
            sweepAngleDegrees = -90.0f,
            forceMoveTo = false
        )
        lineTo(x = topLeft.x + size.width - cornerRadius, y = topLeft.y)
        // Top right arc
        arcTo(
            rect = Rect(
                left = topLeft.x + size.width - cornerRadius,
                top = topLeft.y + -cornerRadius,
                right = topLeft.x + size.width + cornerRadius,
                bottom = topLeft.y + cornerRadius
            ),
            startAngleDegrees = 180.0f,
            sweepAngleDegrees = -90.0f,
            forceMoveTo = false
        )
        lineTo(x = topLeft.x + size.width, y = topLeft.y + size.height - cornerRadius)
        // Bottom right arc
        arcTo(
            rect = Rect(
                left = topLeft.x + size.width - cornerRadius,
                top = topLeft.y + size.height - cornerRadius,
                right = topLeft.x + size.width + cornerRadius,
                bottom = topLeft.y + size.height + cornerRadius
            ),
            startAngleDegrees = 270.0f,
            sweepAngleDegrees = -90.0f,
            forceMoveTo = false
        )
        lineTo(x = topLeft.x + cornerRadius, y = topLeft.y + size.height)
        // Bottom left arc
        arcTo(
            rect = Rect(
                left = topLeft.x + -cornerRadius,
                top = topLeft.y + size.height - cornerRadius,
                right = topLeft.x + cornerRadius,
                bottom = topLeft.y + size.height + cornerRadius
            ),
            startAngleDegrees = 0.0f,
            sweepAngleDegrees = -90.0f,
            forceMoveTo = false
        )
        lineTo(x = topLeft.x, y = topLeft.y + cornerRadius)
        close()
    }
}