package chat.rocket.android.widget;

import android.annotation.TargetApi;
import android.content.Context;
import android.graphics.drawable.Drawable;
import android.os.Build;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.widget.FrameLayout;
import android.widget.ImageView;

import chat.rocket.android.widget.helper.FrescoHelper;
import common.GlideRoundTransform;

import com.bumptech.glide.Glide;
import com.bumptech.glide.Priority;
import com.bumptech.glide.request.RequestOptions;

public class RocketChatAvatar extends FrameLayout {
  RequestOptions options = new RequestOptions()
          .centerCrop()
          .placeholder(R.drawable.icon_user_default)
          .error(R.drawable.icon_user_default)
          .priority(Priority.NORMAL)
          .transform(new GlideRoundTransform());
  private ImageView simpleDraweeViewAvatar;

  public RocketChatAvatar(Context context) {
    super(context);
    initialize(context);
  }

  public RocketChatAvatar(Context context, AttributeSet attrs) {
    super(context, attrs);
    initialize(context);
  }

  public RocketChatAvatar(Context context, AttributeSet attrs, int defStyleAttr) {
    super(context, attrs, defStyleAttr);
    initialize(context);
  }

  @TargetApi(Build.VERSION_CODES.LOLLIPOP)
  public RocketChatAvatar(Context context, AttributeSet attrs, int defStyleAttr, int defStyleRes) {
    super(context, attrs, defStyleAttr, defStyleRes);
    initialize(context);
  }

  private void initialize(Context context) {
    LayoutInflater.from(context).inflate(R.layout.message_avatar, this, true);
    simpleDraweeViewAvatar = findViewById(R.id.drawee_avatar);
  }

  public void loadImage(String imageUri, Drawable placeholderDrawable) {
    Glide.with(this).load(imageUri).apply(options).into(simpleDraweeViewAvatar);
    //FrescoHelper.INSTANCE.loadImage(simpleDraweeViewAvatar, imageUri, placeholderDrawable);
  }

  public void setImageDrawable(Drawable placeholderDrawable){
    simpleDraweeViewAvatar.setImageDrawable(placeholderDrawable);
  }
}