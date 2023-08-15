package com.example.jetpack_compose_all_in_one.ui.components

import androidx.compose.foundation.BorderStroke
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.IntrinsicSize
import androidx.compose.foundation.layout.PaddingValues
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.defaultMinSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.width
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.RadioButton
import androidx.compose.material3.Button
import androidx.compose.material3.ButtonColors
import androidx.compose.material3.ButtonDefaults
import androidx.compose.material3.ButtonElevation
import androidx.compose.material3.Checkbox
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.LocalContentColor
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedButton
import androidx.compose.material3.Switch
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.runtime.Composable
import androidx.compose.runtime.MutableState
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.RectangleShape
import androidx.compose.ui.graphics.Shape
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.TextUnit
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.example.jetpack_compose_all_in_one.ui.theme.dp_3

@Composable
fun SimpleTextButton(
    buttonMessage: String,
    modifier: Modifier = Modifier,
    textModifier: Modifier = Modifier,
    enabled: Boolean = true,
    buttonColors: ButtonColors = ButtonDefaults.buttonColors(),
    textColor: Color = Color.Unspecified,
    fontWeight: FontWeight? = null,
    onClick: () -> Unit
) {
    Button(
        onClick = { onClick() },
        modifier,
        enabled = enabled,
        colors = buttonColors
    ) {
        Text(
            text = buttonMessage,
            modifier = textModifier,
            color = textColor,
            fontWeight = fontWeight
        )
    }
}

@Composable
fun ButtonWithBorder(buttonMessage: String) {
    Button(
        onClick = { },
        border = BorderStroke(dp_3, Color.Black)
    ) {
        Text(text = buttonMessage)
    }
}

@Composable
fun ButtonWithRoundedCorners(buttonMessage: String) {
    Button(
        onClick = { },
        shape = RoundedCornerShape(20.dp)
    ) {
        Text(text = buttonMessage)
    }
}

@Composable
fun OutlinedButton(
    buttonMessage: String,
    modifier: Modifier = Modifier,
    textModifier: Modifier = Modifier,
    onClick: () -> Unit
) {
    OutlinedButton(onClick = { onClick() }, modifier) {
        Text(text = buttonMessage, textModifier)
    }
}

@Composable
fun TextButton(text: String, modifier: Modifier = Modifier, onClick: () -> Unit) {
    TextButton(onClick = onClick, modifier = modifier) {
        Text(text = text)
    }
}

@Composable
fun SimpleIconButton(
    iconResourceInt: Int,
    modifier: Modifier = Modifier,
    iconModifier: Modifier = Modifier,
    tint: Color = Color.Unspecified,
    onClick: () -> Unit) {
    IconButton(onClick = { onClick() }, modifier) {
        Icon(painterResource(id = iconResourceInt), "", iconModifier, tint)
    }
}

@Composable
fun IconTextButton(
    iconResInt: Int?,
    text: String,
    modifier: Modifier = Modifier,
    iconModifier: Modifier = Modifier,
    textModifier: Modifier = Modifier,
    onClick: () -> Unit
) {
    Button(onClick = { onClick() }, modifier) {
        Row() {
            iconResInt?.run{Icon(painterResource(this),"", iconModifier)}
            Text(text, textModifier)
        }
    }
}

@Composable
fun TextButtonWithIcon(
    iconResInt: Int?,
    text: String,
    modifier: Modifier = Modifier,
    iconModifier: Modifier = Modifier,
    textModifier: Modifier = Modifier,
    textColor: Color = LocalContentColor.current,
    iconColor: Color = textColor,
    onClick: () -> Unit
) {
    TextButton(
        onClick = { onClick() },
        modifier
    ) {
        Row {
            iconResInt?.run{
                Icon(painterResource(this),"", iconModifier, tint = iconColor)
            }
            Text(text, textModifier, color = textColor)
        }
    }
}

@Composable
fun TextButton(
    text: String,
    modifier: Modifier = Modifier,
    textModifier: Modifier = Modifier,
    color: Color = Color.Unspecified,
    enabled: Boolean = true,
    fontSize: TextUnit = 16.sp,
    isBold: Boolean = false,
    hasPadding: Boolean = true,
    onClick: () -> Unit
) {
    TextButton(
        onClick = { onClick() },
        modifier = modifier.then(if (hasPadding) Modifier else Modifier.defaultMinSize(1.dp,1.dp)),
        enabled = enabled,
        contentPadding = if (hasPadding) ButtonDefaults.TextButtonContentPadding else PaddingValues(0.dp)
    ) {
        Text(
            text = text, modifier = textModifier, fontSize = fontSize, color = color,
            fontWeight = if (isBold) FontWeight.Bold else FontWeight.Normal
        )
    }
}

@Composable
fun GradientButton(
    text: String,
    gradient: Brush,
    modifier: Modifier = Modifier,
    textColor: Color = LocalContentColor.current,
    textModifier: Modifier = Modifier,
    enabled: Boolean = true,
    shape: Shape = RoundedCornerShape(100),
    elevation: ButtonElevation? = null,
    border: BorderStroke? = null,
    contentPadding: PaddingValues = PaddingValues(0.dp),
    onClick: () -> Unit
) {
    Button(
        onClick = { onClick() },
        modifier = modifier.then(Modifier.background(gradient, shape)),
        enabled = enabled,
        shape = shape,
        colors = ButtonDefaults.buttonColors(
            containerColor = Color.Transparent,
            disabledContainerColor = Color.Transparent),
        elevation = elevation,
        border = border,
        contentPadding = contentPadding,
    ) {
        Box(Modifier,
            contentAlignment = Alignment.Center
        ) {
            Text(
                text = text,
                modifier = textModifier,
                color = textColor,
                textAlign = TextAlign.Center
            )
        }
    }
}

@Composable
fun CheckboxText(
    text: String,
    checked: Boolean,
    modifier: Modifier = Modifier,
    checkboxModifier: Modifier = Modifier,
    enabled: Boolean = true,
    onCheckedChange: ((Boolean) -> Unit)
) {
    Row {
        Checkbox(
            checked = checked,
            onCheckedChange = onCheckedChange,
            modifier = checkboxModifier,
            enabled = enabled
        )
        TextButton(
            text,
            textModifier = modifier,
            enabled = enabled
        ) { onCheckedChange(!checked) }
    }
}

@Composable
fun LabeledSwitch(
    label: Pair<String, String>, // first: off, second: on
    modifier: Modifier = Modifier,
    textModifier: Modifier = Modifier,
    textColor: Color = Color.Unspecified,
    switchState: MutableState<Boolean> = remember{ mutableStateOf(false) },
    onChange: (Boolean) -> Unit
) {
    Row(modifier) {
        Switch(
            checked = switchState.value,
            onCheckedChange = { onChange(it); switchState.value = it }
        )
        Text(
            text = if (switchState.value) label.second else label.first,
            modifier = textModifier,
            color = textColor
        )
    }
}

// textTemplate is the all-in-one place to define text color, style and the rest.
//      Main reason is that modifiers don't really define the common attributes
//      of Text(), and it might not look neat for RadioButtons to copy all
//      the parameters of Text().
@Composable
fun RadioButtons(
    options: List<String>,
    currentOption: String, // This does a string match with the options
    modifier: Modifier = Modifier,
    textTemplate: @Composable (String) -> Unit = {
        Text(it, color = MaterialTheme.colorScheme.onSurface)
    },
    onSelect: (Int) -> Unit // This outputs the index chosen
) {
    @Composable
    fun RadioItem(
        option: Pair<Int, String>,
        isSelected: Boolean,
        textTemplate: @Composable (String) -> Unit,
        onSelect: (Int) -> Unit
    ) {
        Button(
            { onSelect(option.first) },
            shape = RectangleShape,
            colors = ButtonDefaults.textButtonColors()
        ) {
            Row(
                Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.spacedBy(8.dp),
                verticalAlignment = Alignment.CenterVertically
            ) {
                RadioButton(selected = isSelected, onClick = { onSelect(option.first) })
                textTemplate(option.second)
            }
        }
    }

    Column(
        Modifier
            .width(IntrinsicSize.Max)
            .background(androidx.compose.material.MaterialTheme.colors.surface)
            .then(modifier)
    ) {
        options.forEachIndexed { i,v ->
            RadioItem(
                Pair(i, v),
                currentOption == v,
                textTemplate,
                onSelect
            )
        }
    }
}