package com.arkivanov.sample.shared.counters.counter

import com.arkivanov.sample.shared.RProps
import com.arkivanov.sample.shared.componentContent
import com.arkivanov.sample.shared.dialog.DialogComponentContent
import com.arkivanov.sample.shared.useAsState
import csstype.AlignItems
import csstype.BoxSizing
import csstype.number
import mui.material.AppBar
import mui.material.AppBarPosition
import mui.material.Button
import mui.material.ButtonColor
import mui.material.ButtonVariant
import mui.material.Icon
import mui.material.IconButton
import mui.material.IconButtonColor
import mui.material.IconButtonEdge
import mui.material.Size
import mui.material.Stack
import mui.material.Toolbar
import mui.material.Typography
import mui.material.styles.TypographyVariant
import mui.system.responsive
import mui.system.sx
import react.FC

internal val CounterContent: FC<RProps<CounterComponent>> = FC { props ->
    val model by props.component.model.useAsState()

    Stack {
        spacing = responsive(2)

        sx {
            alignItems = AlignItems.center
            boxSizing = BoxSizing.borderBox
        }

        AppBar {
            position = AppBarPosition.static

            Toolbar {
                if (model.isBackEnabled) {
                    IconButton {
                        size = Size.large
                        edge = IconButtonEdge.start
                        color = IconButtonColor.inherit
                        onClick = { props.component.onPrevClicked() }

                        Icon {
                            +"arrow_back"
                        }
                    }
                }

                Typography {
                    sx {
                        flexGrow = number(1.0)
                    }

                    variant = TypographyVariant.h6
                    +model.title
                }
            }
        }

        Typography { +model.text }

        Button {
            variant = ButtonVariant.contained
            color = ButtonColor.primary
            onClick = { props.component.onInfoClicked() }

            +"Info"
        }

        Button {
            variant = ButtonVariant.contained
            color = ButtonColor.primary
            onClick = { props.component.onNextClicked() }

            +"Next"
        }

        Button {
            variant = ButtonVariant.contained
            disabled = !model.isBackEnabled
            onClick = { props.component.onPrevClicked() }

            +"Prev"
        }
    }

    val dialogSlot by props.component.dialogSlot.useAsState()
    dialogSlot.child?.instance?.also { dialog ->
        componentContent(component = dialog, content = DialogComponentContent)
    }
}
