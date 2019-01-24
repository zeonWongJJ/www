package chat.rocket.android.widget.internal

import android.annotation.TargetApi
import android.content.Context
import android.graphics.Color
import android.graphics.drawable.Drawable
import android.os.Build
import android.support.annotation.ColorRes
import android.support.graphics.drawable.VectorDrawableCompat
import android.util.AttributeSet
import android.view.View
import android.widget.FrameLayout
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.TextView

import chat.rocket.android.widget.R
import chat.rocket.android.widget.helper.AvatarHelper
import chat.rocket.android.widget.helper.DrawableHelper
import chat.rocket.android.widget.helper.FrescoHelper
import com.bumptech.glide.Glide
import com.bumptech.glide.Priority
import com.bumptech.glide.request.RequestOptions
import common.GlideRoundTransform

/**
 * Room list-item view used in sidebar.
 */
class RoomListItemView : FrameLayout {
    lateinit private var roomId: String
    lateinit private var userIcon: ImageView;
    lateinit private var roomTypeImage: ImageView
    lateinit private var userStatusImage: ImageView
    lateinit private var roomNameText: TextView
    lateinit private var alertCountText: TextView
    lateinit private var privateChannelDrawable: Drawable
    lateinit private var publicChannelDrawable: Drawable
    lateinit private var livechatChannelDrawable: Drawable
    lateinit private var userStatusDrawable: Drawable

    constructor(context: Context) : super(context) {
        initialize(context)
    }

    constructor(context: Context, attrs: AttributeSet) : super(context, attrs) {
        initialize(context)
    }

    constructor(context: Context, attrs: AttributeSet, defStyleAttr: Int) : super(context, attrs, defStyleAttr) {
        initialize(context)
    }

    @TargetApi(Build.VERSION_CODES.LOLLIPOP)
    constructor(context: Context, attrs: AttributeSet, defStyleAttr: Int, defStyleRes: Int) : super(context, attrs, defStyleAttr, defStyleRes) {
        initialize(context)
    }

    private fun initialize(context: Context) {
        layoutParams = LinearLayout.LayoutParams(FrameLayout.LayoutParams.MATCH_PARENT, FrameLayout.LayoutParams.WRAP_CONTENT)

        val array = context
                .theme
                .obtainStyledAttributes(intArrayOf(R.attr.selectableItemBackground))

        background = array.getDrawable(0)
        array.recycle()

        View.inflate(context, R.layout.room_list_item, this)
        userIcon=findViewById(R.id.drawee_avatar)
        roomTypeImage = findViewById(R.id.image_room_type)
        roomTypeImage.setColorFilter(Color.BLUE)
        userStatusImage = findViewById(R.id.image_user_status)
        roomNameText = findViewById(R.id.text_room_name)
        alertCountText = findViewById(R.id.text_alert_count)

        privateChannelDrawable = VectorDrawableCompat.create(resources, R.drawable.ic_lock_white_24dp, null)!!
        publicChannelDrawable = VectorDrawableCompat.create(resources, R.drawable.ic_hashtag_white_24dp, null)!!
        livechatChannelDrawable = VectorDrawableCompat.create(resources, R.drawable.ic_livechat_white_24dp, null)!!
        userStatusDrawable = VectorDrawableCompat.create(resources, R.drawable.ic_user_status_black_24dp, null)!!
    }

    fun setRoomId(roomId: String) {
        this.roomId = roomId
    }

    fun setUnreadCount(count: Int) {
        if (count > 0) {
            alertCountText.text = count.toString()
            alertCountText.visibility = View.VISIBLE
        } else {
            alertCountText.visibility = View.GONE
        }
    }

    fun setAlert(alert: Boolean) {
        alpha = if (alert) 1.0f else 0.62f
    }

    fun setRoomName(roomName: String) {
        roomNameText.text = roomName
    }
    /*fun showAvatar(rocketChatAvatarWidget: RocketChatAvatar, hostname: String) {
        val username: String? = message.user?.username
        if (username != null) {
            val placeholderDrawable = AvatarHelper.getTextDrawable(username, rocketChatAvatarWidget.context)
            if (message.avatar != null) {
                // Load user's avatar image from Oauth provider URI.
                rocketChatAvatarWidget.loadImage(message.avatar, placeholderDrawable)
            } else {
                rocketChatAvatarWidget.loadImage(AvatarHelper.getUri(hostname, username), placeholderDrawable)
            }
        } else {
            rocketChatAvatarWidget.visibility = View.GONE
        }
    }*/
    fun setUserIcon(hostname:String,username:String){
        val placeholderDrawable = AvatarHelper.getTextDrawable(username,context)
        loadImage(AvatarHelper.getUri(hostname, username), placeholderDrawable)
    }

    /*private val options = RequestOptions()
            .centerCrop()
            .placeholder(R.drawable.image_dummy)
            .error(R.drawable.image_error)
            .priority(Priority.NORMAL)
            .transform(GlideRoundTransform())*/
    val options=RequestOptions()
            .centerCrop()
            .placeholder(R.drawable.icon_user_default)
            .error(R.drawable.icon_user_default)
            .priority(Priority.NORMAL)
            .transform(GlideRoundTransform())
    fun loadImage(imageUri: String, placeholderDrawable: Drawable) {
        Glide.with(this.context).load(imageUri).apply(options).into(userIcon);
        //FrescoHelper.loadImage(userIcon, imageUri, placeholderDrawable)
    }
    fun showPrivateChannelIcon() {
        roomTypeImage.setImageDrawable(privateChannelDrawable)
        userStatusImage.visibility = View.GONE
        roomTypeImage.visibility = View.VISIBLE
    }

    fun showPublicChannelIcon() {
        roomTypeImage.setImageDrawable(publicChannelDrawable)
        userStatusImage.visibility = View.GONE
        roomTypeImage.visibility = View.VISIBLE
    }

    fun showLivechatChannelIcon() {
        roomTypeImage.setImageDrawable(livechatChannelDrawable)
        userStatusImage.visibility = View.GONE
        roomTypeImage.visibility = View.VISIBLE
    }

    fun showOnlineUserStatusIcon() {
        prepareDrawableAndShow(R.color.color_user_status_online)
    }

    fun showBusyUserStatusIcon() {
        prepareDrawableAndShow(R.color.color_user_status_busy)
    }

    fun showAwayUserStatusIcon() {
        prepareDrawableAndShow(R.color.color_user_status_away)
    }

    fun showOfflineUserStatusIcon() {
        prepareDrawableAndShow(R.color.color_user_status_offline)
    }

    private fun prepareDrawableAndShow(@ColorRes resId: Int) {
        DrawableHelper.wrapDrawable(userStatusDrawable)
        DrawableHelper.tintDrawable(userStatusDrawable, context, resId)
        userStatusImage.setImageDrawable(userStatusDrawable)
        roomTypeImage.visibility = View.GONE
        userStatusImage.visibility = View.VISIBLE
    }
}