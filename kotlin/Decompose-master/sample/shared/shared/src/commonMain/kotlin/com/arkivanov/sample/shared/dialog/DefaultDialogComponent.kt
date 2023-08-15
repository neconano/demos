package com.arkivanov.sample.shared.dialog

class DefaultDialogComponent(
    override val title: String,
    override val message: String,
    private val onDismissed: () -> Unit,
) : DialogComponent {
    override fun onDismissClicked() {
        onDismissed()
    }
}
