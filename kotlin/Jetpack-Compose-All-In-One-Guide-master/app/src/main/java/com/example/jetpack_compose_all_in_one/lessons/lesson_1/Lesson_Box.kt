package com.example.jetpack_compose_all_in_one.lessons.lesson_1

import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import com.example.jetpack_compose_all_in_one.ui.components.CustomSpacer
import com.example.jetpack_compose_all_in_one.ui.components.LessonHeader
import com.example.jetpack_compose_all_in_one.ui.components.StyleableLessonText
import com.example.jetpack_compose_all_in_one.ui.theme.dp_5


/**
 * Lesson about [Box] and [Modifier]s.
 *
 * * [Box] stacks it's children on top of each other.
 */
@Composable
fun LessonBox() {

    LazyColumn(Modifier.fillMaxSize()) {

        item {
            LessonHeader(text = "Box")
            StyleableLessonText(
                text = "**Box** aligns children on top of each other like a Stack. " +
                        "The one declared last is on top"
            )
            BoxExample()
            CustomSpacer(height = dp_5)

            StyleableLessonText(
                text = "Elements in Box can be aligned with different alignments."
            )
            BoxShadowAndAlignmentExample()

            LessonHeader(text = "Spacer")

            StyleableLessonText(
                text = "Spacer can be used to align elements to end or bottom of screen"
            )
            WeightExample()
            CustomSpacer(height = dp_5)

            LessonHeader(text = "Weight and Spacer")
            StyleableLessonText(
                text = "8-) **Weight** determines, based on total weight, how much of the parent's " +
                        "dimensions should be occupied by each child. **Spacer** is used to " +
                        "create horizontal or vertical " +
                        "space between components."
            )
            WeightAndSpacerExample()
            CustomSpacer(height = dp_5)
        }
    }
}

