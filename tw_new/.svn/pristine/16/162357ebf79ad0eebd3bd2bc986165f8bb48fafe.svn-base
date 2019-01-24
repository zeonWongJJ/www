package com.qidu.chat.renderer

import android.support.v4.app.FragmentActivity
import android.view.View
import android.widget.LinearLayout
import android.widget.TextView
import com.qidu.chat.R
import com.qidu.chat.helper.DateTime
import chat.rocket.android.widget.AbsoluteUrl
import chat.rocket.android.widget.RocketChatAvatar
import chat.rocket.android.widget.helper.AvatarHelper
import chat.rocket.android.widget.message.RocketChatMessageAttachmentsLayout
import chat.rocket.android.widget.message.RocketChatMessageLayout
import chat.rocket.android.widget.message.RocketChatMessageUrlsLayout
import chat.rocket.core.SyncState
import chat.rocket.core.models.Message

class MessageRenderer(val activity:FragmentActivity,val message: Message, val autoLoadImage: Boolean) {

    /**
     * Show user's avatar image in RocketChatAvatar widget.
     */
    fun showAvatar(rocketChatAvatarWidget: RocketChatAvatar, hostname: String) {
        val username: String? = message.user?.username
        if (username != null) {
            rocketChatAvatarWidget.visibility = View.VISIBLE
            val placeholderDrawable = AvatarHelper.getTextDrawable(username, rocketChatAvatarWidget.context)
            if (message.avatar != null) {
                // Load user's avatar image from Oauth provider URI.
                //rocketChatAvatarWidget.loadImage(message.avatar, placeholderDrawable)
                rocketChatAvatarWidget.setImageDrawable(placeholderDrawable)
            } else {
                rocketChatAvatarWidget.loadImage(AvatarHelper.getUri(hostname, username), placeholderDrawable)
            }
        } else {
            rocketChatAvatarWidget.visibility = View.GONE
        }
    }

    /**
     * Show username in textView.
     */
    fun showUsername(usernameTextView: TextView, subUsernameTextView: TextView?) {
        val username: String? = message.user?.username
        if (username != null) {
            if (message.alias == null) {
                usernameTextView.text = username
            } else {
                usernameTextView.text = message.alias
                if (subUsernameTextView != null) {
                    subUsernameTextView.text = subUsernameTextView.context.getString(R.string.sub_username, username)
                    subUsernameTextView.visibility = View.VISIBLE
                }
            }
        }
    }

    /**
     * Show timestamp or message state in textView.
     */
    fun showTimestampOrMessageState(textView: TextView) {
        when (message.syncState) {
            SyncState.SYNCING -> textView.text = textView.context.getText(R.string.sending)
            SyncState.NOT_SYNCED -> textView.text = textView.context.getText(R.string.not_synced)
            SyncState.FAILED -> textView.text = textView.context.getText(R.string.failed_to_sync)
            else -> textView.text = DateTime.fromEpocMs(message.timestamp, DateTime.Format.TIME)
        }
    }

    /**
     * Show body in RocketChatMessageLayout widget.
     */
    fun showBody(rocketChatMessageLayout: RocketChatMessageLayout,position:Int, isSelf:Boolean,bodyUrlsVontainer: LinearLayout) {


        if (message.message == null || message.message.isEmpty()) {
            rocketChatMessageLayout.visibility = View.GONE
        } else{
            /*val webContents = message.webContents
            if (webContents == null || webContents.isEmpty()) {
                rocketChatMessageLayout.setText(activity, message.message, isSelf)
            }else{
                rocketChatMessageLayout.visibility = View.GONE
            }*/
            bodyUrlsVontainer.visibility = View.VISIBLE
            rocketChatMessageLayout.visibility = View.VISIBLE
            rocketChatMessageLayout.setText(activity, message,position, isSelf)
        }
    }

    /**
     * Show urls in RocketChatMessageUrlsLayout widget.
     */
    fun showUrl(rocketChatMessageUrlsLayout: RocketChatMessageUrlsLayout,isSelf:Boolean) {
        val webContents = message.webContents
        if (webContents == null || webContents.isEmpty()) {
            rocketChatMessageUrlsLayout.visibility = View.GONE
        } else {
            rocketChatMessageUrlsLayout.setUrls(activity,webContents, autoLoadImage,isSelf)
            rocketChatMessageUrlsLayout.visibility = View.VISIBLE
        }
    }

    /**
     * show attachments in RocketChatMessageAttachmentsLayout widget.
     */
    fun showAttachment(rocketChatMessageAttachmentsLayout: RocketChatMessageAttachmentsLayout, absoluteUrl: AbsoluteUrl?,isSelf: Boolean,bodyUrlsVontainer: LinearLayout,audioPlayListener: View.OnClickListener) {
        val attachments = message.attachments
        if (attachments == null || attachments.isEmpty()) {
            rocketChatMessageAttachmentsLayout.visibility = View.GONE
        } else {
            bodyUrlsVontainer.visibility = View.GONE
            rocketChatMessageAttachmentsLayout.visibility = View.VISIBLE
            rocketChatMessageAttachmentsLayout.setAbsoluteUrl(absoluteUrl)
            rocketChatMessageAttachmentsLayout.setAttachments(activity,attachments, autoLoadImage,isSelf,audioPlayListener)
        }
    }
}