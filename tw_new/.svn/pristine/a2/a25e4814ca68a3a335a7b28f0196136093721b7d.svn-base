package chat.rocket.android.widget.message;

import android.annotation.TargetApi;
import android.app.Application;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.media.MediaMetadataRetriever;
import android.media.MediaPlayer;
import android.net.Uri;
import android.os.Build;
import android.os.Environment;
import android.support.annotation.Nullable;
import android.support.v4.app.FragmentActivity;
import android.support.v4.widget.TextViewCompat;
import android.text.TextUtils;
import android.util.AttributeSet;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import bean.DefaultEventEntity;
import chat.rocket.android.widget.AbsoluteUrl;
import chat.rocket.android.widget.ChatImageView;
import chat.rocket.android.widget.R;
import chat.rocket.android.widget.helper.FrescoHelper;
import chat.rocket.core.models.Attachment;
import chat.rocket.core.models.AttachmentAuthor;
import chat.rocket.core.models.AttachmentField;
import chat.rocket.core.models.AttachmentTitle;
import chat.rocket.core.utils.CommonKey;
import common.Constants;
import common.GlideRoundTransform;
import common.utils.DownloadUtil;
import common.utils.VoicePlayingBgUtil;
import io.reactivex.Observable;
import io.reactivex.ObservableEmitter;
import io.reactivex.ObservableOnSubscribe;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;
import videoplay.lib.PlayActivity;

import com.bumptech.glide.Glide;
import com.bumptech.glide.Priority;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.request.RequestOptions;
import com.bumptech.glide.request.target.BitmapImageViewTarget;
import com.bumptech.glide.request.target.DrawableImageViewTarget;
import com.bumptech.glide.request.target.ImageViewTarget;
import com.bumptech.glide.request.target.SimpleTarget;
import com.bumptech.glide.request.transition.Transition;
import com.danikula.videocache.HttpProxyCacheServer;
import com.luck.picture.lib.PicturePlayAudioActivity;
import com.luck.picture.lib.PictureSelector;
import com.luck.picture.lib.config.PictureConfig;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.tools.PictureFileUtils;
import com.luck.picture.lib.tools.ScreenUtils;
import com.luck.picture.lib.tools.VoiceUtils;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;

/**
 */
public class RocketChatMessageAttachmentsLayout extends LinearLayout {
  private LayoutInflater inflater;
  private AbsoluteUrl absoluteUrl;
  private List<Attachment> attachments;
  private FragmentActivity activity;
  private RequestOptions options = new RequestOptions()
          .centerCrop()
          .diskCacheStrategy(DiskCacheStrategy.ALL)// 缓存所有尺寸的图片
          .placeholder(R.drawable.image_dummy)
          .error(R.drawable.image_error)
          .priority(Priority.NORMAL)

          .transform(new GlideRoundTransform());
  private RequestOptions optionsImg = new RequestOptions()
          .centerCrop()
          .diskCacheStrategy(DiskCacheStrategy.ALL)// 缓存所有尺寸的图片
          .placeholder(R.drawable.image_dummy)
          .error(R.drawable.image_error)
          .priority(Priority.NORMAL);
  public RocketChatMessageAttachmentsLayout(Context context) {
    super(context);
    initialize(context, null);
  }

  public RocketChatMessageAttachmentsLayout(Context context, AttributeSet attrs) {
    super(context, attrs);
    initialize(context, attrs);
  }

  public RocketChatMessageAttachmentsLayout(Context context, AttributeSet attrs, int defStyleAttr) {
    super(context, attrs, defStyleAttr);
    initialize(context, attrs);
  }

  @TargetApi(Build.VERSION_CODES.LOLLIPOP)
  public RocketChatMessageAttachmentsLayout(Context context, AttributeSet attrs, int defStyleAttr,
                                            int defStyleRes) {
    super(context, attrs, defStyleAttr, defStyleRes);
    initialize(context, attrs);
  }

  private void initialize(Context context, AttributeSet attrs) {
    inflater = LayoutInflater.from(context);
    setOrientation(VERTICAL);
  }

  public void setAbsoluteUrl(AbsoluteUrl absoluteUrl) {
    this.absoluteUrl = absoluteUrl;
  }

  public void setAttachments(FragmentActivity activity, List<Attachment> attachments, boolean autoloadImages,boolean isSelf,OnClickListener audioPlayListener) {
    if (activity!=null&&this.attachments != null && this.attachments.equals(attachments)) {
      return;
    }
    this.setBackgroundDrawable(null);
    this.attachments = attachments;
    this.activity=activity;
    removeAllViews();

    for (int i = 0, size = attachments.size(); i < size; i++) {
      appendAttachmentView(attachments.get(i), autoloadImages,isSelf,audioPlayListener);
    }
  }

  public void appendAttachmentView(Attachment attachment, boolean autoloadImages,boolean isSelf,OnClickListener audioPlayListener) {
    if (attachment == null) {
      return;
    }

    View attachmentView = inflater.inflate(R.layout.message_inline_attachment, this, false);
    addView(attachmentView);
    colorizeAttachmentBar(attachment, attachmentView);
    showAuthorAttachment(attachment, attachmentView);
    showTitleAttachment(attachment, attachmentView,isSelf,audioPlayListener);
    showReferenceAttachment(attachment, attachmentView);
    showImageAttachment(attachment, attachmentView, autoloadImages,isSelf);
    // audio
    // video
    showFieldsAttachment(attachment, attachmentView);
  }

  private void colorizeAttachmentBar(Attachment attachment, View attachmentView) {
    final View attachmentStrip = attachmentView.findViewById(R.id.attachment_strip);

    final String colorString = attachment.getColor();
    if (TextUtils.isEmpty(colorString)) {
      attachmentStrip.setBackgroundResource(R.color.inline_attachment_quote_line);
      //return;
    }else {

      try {
        attachmentStrip.setBackgroundColor(Color.parseColor(colorString));
      } catch (Exception e) {
        attachmentStrip.setBackgroundResource(R.color.inline_attachment_quote_line);
      }
    }
  }

  private void showAuthorAttachment(Attachment attachment, View attachmentView) {
    final View authorBox = attachmentView.findViewById(R.id.author_box);
    AttachmentAuthor author = attachment.getAttachmentAuthor();
    if (author == null) {
      authorBox.setVisibility(GONE);
      //return;
    }else {

      authorBox.setVisibility(VISIBLE);
      Glide.with(this).load(absolutize(author.getIconUrl())).apply(options).into((ImageView) attachmentView.findViewById(R.id.author_icon));
      //FrescoHelper.INSTANCE.loadImageWithCustomization((SimpleDraweeView) attachmentView.findViewById(R.id.author_icon), absolutize(author.getIconUrl()));

      final TextView authorName = (TextView) attachmentView.findViewById(R.id.author_name);
      authorName.setText(author.getName());

      final String link = absolutize(author.getLink());
      authorName.setOnClickListener(new OnClickListener() {
        @Override
        public void onClick(View view) {
        /*Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(link));
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        view.getContext().startActivity(intent);*/
          Intent it = new Intent();
          //设置Intent的Action属性
          it.setAction(CommonKey.KEY_ACTION_URL_WEB_VIEW_OPEN);
          it.putExtra("url", link);
          //it.putExtra("title",title);
          getContext().startActivity(it);
        }
      });
    }
    // timestamp and link - need to format time
  }

  private void showTitleAttachment(final Attachment attachment, View attachmentView,final boolean isSelf,final OnClickListener audioPlayListener) {
    View videoAudioLayout=attachmentView.findViewById(R.id.video_audio_layout);
    TextView titleView = attachmentView.findViewById(R.id.title);
    final TextView audioPlay =attachmentView.findViewById(R.id.audio_play);
    final ImageView videoPlay =attachmentView.findViewById(R.id.video_play);
    final ChatImageView videoPicture=attachmentView.findViewById(R.id.video_picture);
    final ChatImageView videoPictureRight=attachmentView.findViewById(R.id.video_picture_right);
    final AttachmentTitle title = attachment.getAttachmentTitle();

    if (title == null || title.getTitle() == null) {
      titleView.setVisibility(View.GONE);
      videoAudioLayout.setVisibility(GONE);
      //return;
    }else {
      videoAudioLayout.setVisibility(VISIBLE);
      titleView.setVisibility(View.GONE);//全部title都不要显示了
      titleView.setText(title.getTitle());


      if (title.getLink() == null) {
        titleView.setOnClickListener(null);
        titleView.setClickable(false);
        audioPlay.setOnClickListener(null);
        audioPlay.setClickable(false);
        videoPlay.setOnClickListener(null);
        videoPlay.setClickable(false);
      } else {
        final String link = absolutize(title.getLink());
        if (attachment.getVideoUrl() == null && attachment.getAudioUrl() != null) {
          final VoicePlayingBgUtil voicePlayingBgUtil = new VoicePlayingBgUtil();
          voicePlayingBgUtil.setImageView(audioPlay);
          if (isSelf) {
            videoAudioLayout.setBackground(activity.getResources().getDrawable(R.drawable.message_right));
            audioPlay.setCompoundDrawablesWithIntrinsicBounds(0, 0, R.drawable.right_voice_three, 0);
            audioPlay.setGravity(Gravity.RIGHT | Gravity.CENTER_VERTICAL);
            voicePlayingBgUtil.setModelType(2);
          } else {
            videoAudioLayout.setBackground(activity.getResources().getDrawable(R.drawable.message_left));
            audioPlay.setCompoundDrawablesWithIntrinsicBounds(R.drawable.left_voice_three, 0, 0, 0);
            audioPlay.setGravity(Gravity.LEFT | Gravity.CENTER_VERTICAL);
            voicePlayingBgUtil.setModelType(1);
          }

          audioPlay.setVisibility(VISIBLE);
          videoPlay.setVisibility(GONE);

          Observable observable = Observable.create(new ObservableOnSubscribe() {
            @Override
            public void subscribe(final ObservableEmitter e) throws Exception {
              final String fileName=title.getTitle()/*+".mp3"*/;
              //Log.i("bbbbb","mp3----->"+fileName);
              String path = DownloadUtil.getInstance().getFilePathByKey(DownloadUtil.downLoad,fileName);

              if (path != null) {
                e.onNext(path);
              } else {
                DownloadUtil.getInstance().download(link, DownloadUtil.downLoad, fileName,new DownloadUtil.OnDownloadListener() {
                  @Override
                  public void onDownloadSuccess() {
                    /*Utils.showToast(MainActivity.this, "下载完成");*/
                    String path = DownloadUtil.getInstance().getFilePathByKey(DownloadUtil.downLoad,fileName);
                    e.onNext(path);
                  }

                  @Override
                  public void onDownloading(int progress) {
                    //progressBar.setProgress(progress);
                  }

                  @Override
                  public void onDownloadFailed() {
                    //Utils.showToast(MainActivity.this, "下载失败");
                    e.onNext("");
                  }
                });
              }
              //e.onComplete();
            }
          });
          Disposable disposable = (Disposable) observable/*.subscribeOn(Schedulers.io()).unsubscribeOn(Schedulers.io())*/.observeOn(AndroidSchedulers.mainThread()).subscribeWith(new DisposableObserver<String>() {
            @Override
            public void onError(Throwable e) {
              //reDisposable(observable);
            }

            @Override
            public void onComplete() {
            }

            @Override
            public void onNext(final String path) {
              long duration;
              if(path==null||path.isEmpty()) {
                duration=0;
              }else {
                MediaMetadataRetriever mmr = new MediaMetadataRetriever();
                mmr.setDataSource(path);
                duration= Integer.parseInt(mmr.extractMetadata(MediaMetadataRetriever.METADATA_KEY_DURATION));
              }
              audioPlay.setText(long2String(duration));
              if (duration > 1000 * 60 * 0.25 && duration <= 1000 * 60 * 0.5) {
                FrameLayout.LayoutParams params = (FrameLayout.LayoutParams) audioPlay.getLayoutParams();
                params.width = ScreenUtils.dip2px(activity, 110);
                params.height = ScreenUtils.dip2px(activity, 40);
                audioPlay.setLayoutParams(params);
                audioPlay.requestLayout();
              } else if (duration > 1000 * 60 * 0.5) {
                FrameLayout.LayoutParams params = (FrameLayout.LayoutParams) audioPlay.getLayoutParams();
                params.width = ScreenUtils.dip2px(activity, 140);
                params.height = ScreenUtils.dip2px(activity, 40);
                audioPlay.setLayoutParams(params);
                audioPlay.requestLayout();
              } else if (duration <= 1000 * 60 * 0.25) {//15/60=0.25 15秒以内

                FrameLayout.LayoutParams params = (FrameLayout.LayoutParams) audioPlay.getLayoutParams();
                params.width = ScreenUtils.dip2px(activity, 80);
                params.height = ScreenUtils.dip2px(activity, 40);
                audioPlay.setLayoutParams(params);
                audioPlay.requestLayout();
              }

              audioPlay.setTag(R.id.tag_voice_path, path);
              audioPlay.setTag(R.id.tag_voice_animation, voicePlayingBgUtil);
              audioPlay.setOnClickListener(audioPlayListener);

            }
          });

        } else if (attachment.getVideoUrl() != null && attachment.getAudioUrl() == null) {
          String videoPath=link;
          File sd= Environment.getExternalStorageDirectory();
          String path=sd.getPath()+DownloadUtil.videoLoad;
          File file=new File(path);
          if(!file.exists()){
            file.mkdir();
          }
          File filePath = new File(file,title.getTitle());
          if(filePath.exists()){
            //Log.i("bbbbbb",filePath.getAbsolutePath()+"");
            videoPath=filePath.getAbsolutePath();
          }
          //final String path = DownloadUtil.getInstance().getFilePathByKey(DownloadUtil.videoLoad, link);
            audioPlay.setVisibility(GONE);
            videoPlay.setVisibility(VISIBLE);
          if (isSelf) {
            videoPictureRight.setVisibility(VISIBLE);
            loadVideoImage(videoPath,videoPictureRight);

            //Glide.with(activity).load(Uri.parse(link)).thumbnail(0.1f).into(videoPicture);
          } else {
            videoPicture.setVisibility(VISIBLE);
            loadVideoImage(videoPath,videoPicture);
            /*Glide.with(activity).load(videoPath).thumbnail(0.1f).into(new SimpleTarget<Drawable>() {
              @Override
              public void onResourceReady(Drawable resource, Transition<? super Drawable> transition) {
                videoPicture.setImageDrawable(resource);
                videoPicture.requestLayout();
              }
            });*/

          }

          final String finalVideoPath = videoPath;
          videoPlay.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
              //PictureSelector.create(activity).externalPictureVideo(link);
              Intent intent = new Intent(activity, PlayActivity.class);
              intent.putExtra("video_path", finalVideoPath);
              activity.startActivity(intent);
            }
          });

        } else if (attachment.getImageUrl() != null) {
          titleView.setVisibility(View.GONE);
        } else {
          if (isSelf) {
            this.setBackgroundDrawable(activity.getResources().getDrawable(R.drawable.message_right));
          } else {
            this.setBackgroundDrawable(activity.getResources().getDrawable(R.drawable.message_left));
          }
          titleView.setVisibility(View.VISIBLE);//text等等之类的文件没有判断，放这里显示
          titleView.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
              /*final Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(link));
              intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
              final Context context = view.getContext();
              if (intent.resolveActivity(context.getPackageManager()) != null) {
                context.startActivity(intent);
              }*/
              Intent intent=new Intent("com.qidu.chat.activity.FileDownLoadActivity");
              intent.putExtra("title",title.getTitle());
              intent.putExtra("link",link);
              view.getContext().startActivity(intent);
            }
          });

        }

        TextViewCompat.setTextAppearance(titleView,
                R.style.TextAppearance_RocketChat_MessageAttachment_Title_Link);
      }
    }
  }

  private void loadVideoImage(final String videoPath, final ChatImageView drawee){
    Glide.with(activity).load(videoPath).thumbnail(0.1f).apply(optionsImg).into(new SimpleTarget<Drawable>() {
      @Override
      public void onResourceReady(Drawable resource, Transition<? super Drawable> transition) {
        int width = resource.getIntrinsicWidth();
        int height = resource.getIntrinsicHeight();
        //获取imageView的宽
        //int imageViewWidth= drawee.getWidth();
        int imageViewWidth;
        if(width>=height){
          imageViewWidth=300;
        }else {
          imageViewWidth=200;
        }
        //计算缩放比例
        float sy= (float) (imageViewWidth* 0.1)/(float) (width * 0.1);
        //计算图片等比例放大后的高
        int imageViewHeight= (int) (height * sy);
        FrameLayout.LayoutParams params = (FrameLayout.LayoutParams) drawee.getLayoutParams();
        params.height = imageViewHeight;
        params.width=imageViewWidth;
        drawee.setLayoutParams(params);
        drawee.setImageDrawable(resource);
                /*videoPictureRight.setImageDrawable(resource);
                videoPictureRight.requestLayout();*/
      }
      @Override
      public void onLoadFailed(@Nullable Drawable errorDrawable) {
        super.onLoadFailed(errorDrawable);
        //videoPictureRight.setImageDrawable(activity.getResources().getDrawable(R.drawble.du));
      }
    });
  }

  //毫秒转秒
  public static String long2String(long time){

    //毫秒转秒
    int sec = (int) time / 1000 ;
    int min = sec / 60 ;	//分钟
    sec = sec % 60 ;		//秒
    if(min < 10){	//分钟补0
      if(sec < 10){	//秒补0
        return "0"+min+":0"+sec;
      }else{
        return "0"+min+":"+sec;
      }
    }else{
      if(sec < 10){	//秒补0
        return min+":0"+sec;
      }else{
        return min+":"+sec;
      }
    }

  }
  private void showReferenceAttachment(Attachment attachment, View attachmentView) {
    final View refBox = attachmentView.findViewById(R.id.ref_box);
    if (attachment.getThumbUrl() == null && attachment.getText() == null) {
      refBox.setVisibility(GONE);
      //return;
    }else {

      refBox.setVisibility(VISIBLE);

      final ImageView thumbImage = (ImageView) refBox.findViewById(R.id.thumb);

      final String thumbUrl = attachment.getThumbUrl();
      if (TextUtils.isEmpty(thumbUrl)) {
        thumbImage.setVisibility(GONE);
      } else {
        thumbImage.setVisibility(VISIBLE);

        Glide.with(this).load(absolutize(thumbUrl)).apply(options).into(thumbImage);
        //FrescoHelper.INSTANCE.loadImageWithCustomization(thumbImage, absolutize(thumbUrl));
      }

      final TextView refText = (TextView) refBox.findViewById(R.id.text);

      final String refString = attachment.getText();
      if (TextUtils.isEmpty(refString)) {
        refText.setVisibility(GONE);
      } else {
        refText.setVisibility(VISIBLE);
        refText.setText(refString);
      }
    }
  }

  private void showImageAttachment(Attachment attachment, View attachmentView,
                                   boolean autoloadImages,boolean isSelf) {
    final View imageContainer = attachmentView.findViewById(R.id.image_container);
    if (attachment.getImageUrl() == null) {
      imageContainer.setVisibility(GONE);
      //return;用reture的话会导致后面要显示文件的方法不能显示
    }else {
      final String url=absolutize(attachment.getImageUrl());
      imageContainer.setVisibility(VISIBLE);
      final View load = attachmentView.findViewById(R.id.image_load);
      /*ChatImageView*/
      final ChatImageView attachedImageLeft = attachmentView.findViewById(R.id.image_left);
      final ChatImageView attachedImageRight = attachmentView.findViewById(R.id.image_right);
      final ImageView imageGif = attachmentView.findViewById(R.id.image_file);
    /*
      load.setVisibility(GONE);
      imageGif.setVisibility(VISIBLE);
      Glide.with(activity).load(url).apply(options).into(imageGif);
      imageGif.setOnClickListener(new OnClickListener() {
        @Override
        public void onClick(View v) {
          List<LocalMedia> list=new ArrayList<>();
          LocalMedia media=new LocalMedia();
          media.setPath(url);
          list.add(media);
          PictureSelector.create(activity).externalPicturePreview(0,list );
        }
      });*/






      if(attachment.getImageType()!=null&&attachment.getImageType().equals("image/gif")){
        load.setVisibility(GONE);
        imageGif.setVisibility(VISIBLE);
        Glide.with(activity).load(url)/*.apply(optionsImg)*/.into(imageGif);
        /*Glide.with(activity).load(url).apply(optionsImg).into(new SimpleTarget<Drawable>() {
          @Override
          public void onResourceReady(Drawable resource, Transition<? super Drawable> transition) {
            int width = resource.getIntrinsicWidth();
            int height = resource.getIntrinsicHeight();
            //获取imageView的宽
            //int imageViewWidth= drawee.getWidth();
            int imageViewWidth;
            if(width>=height){
              imageViewWidth=300;
            }else {
              imageViewWidth=200;
            }
            //计算缩放比例
            float sy= (float) (imageViewWidth* 0.1)/(float) (width * 0.1);
            //计算图片等比例放大后的高
            int imageViewHeight= (int) (height * sy);
            FrameLayout.LayoutParams params = (FrameLayout.LayoutParams) imageGif.getLayoutParams();
            params.height = imageViewHeight;
            params.width=imageViewWidth;
            imageGif.setLayoutParams(params);
            imageGif.setImageDrawable(resource);
            //drawee.requestLayout();
          }
          @Override
          public void onLoadFailed(@Nullable Drawable errorDrawable) {
            super.onLoadFailed(errorDrawable);
            imageGif.setImageDrawable(activity.getResources().getDrawable(R.drawable.image_dummy));
          }
        });*/
        imageGif.setOnClickListener(new OnClickListener() {
          @Override
          public void onClick(View v) {
            List<LocalMedia> list=new ArrayList<>();
            LocalMedia media=new LocalMedia();
            media.setPath(url);
            list.add(media);
            PictureSelector.create(activity).externalPicturePreview(0,list );
          }
        });
      }else {
        if (isSelf) {
          attachedImageRight.setVisibility(VISIBLE);
          loadImage(url, attachedImageRight, load, autoloadImages);
        } else {
          attachedImageLeft.setVisibility(VISIBLE);
          loadImage(url, attachedImageLeft, load, autoloadImages);
        }
      }
    }
    //load.setVisibility(GONE);
    // Fix for https://fabric.io/rocketchat3/android/apps/chat.rocket.android/issues/59982403be077a4dcc4d7dc3/sessions/599F217000CF00015C771EEF2021AA0F_f9320e3f88fd11e7935256847afe9799_0_v2?
    // From: https://github.com/facebook/fresco/issues/1176#issuecomment-216830098
    // android.support.v4.content.ContextCompat creates your vector drawable
    /*Drawable placeholderDrawable = ContextCompat.getDrawable(getContext(), R.drawable.image_dummy);

    // Set the placeholder image to the placeholder vector drawable
    attachedImage.setHierarchy(
            GenericDraweeHierarchyBuilder.newInstance(getResources())
                    .setPlaceholderImage(placeholderDrawable)
                    .build());*/

  }

  private void showFieldsAttachment(Attachment attachment, View attachmentView) {
    List<AttachmentField> fields = attachment.getAttachmentFields();
    if (fields == null || fields.size() == 0) {
      return;
    }

    final ViewGroup attachmentContent =
        (ViewGroup) attachmentView.findViewById(R.id.attachment_content);

    for (int i = 0, size = fields.size(); i < size; i++) {
      final AttachmentField attachmentField = fields.get(i);
      if (attachmentField.getTitle() == null
          || attachmentField.getText() == null) {
        return;
      }
      MessageAttachmentFieldLayout fieldLayout = new MessageAttachmentFieldLayout(getContext());

      fieldLayout.setTitle(attachmentField.getTitle());
      fieldLayout.setValue(attachmentField.getText());

      attachmentContent.addView(fieldLayout);
    }
  }

  private String absolutize(String url) {
    if (absoluteUrl == null) {
      return url;
    }
    return absoluteUrl.from(url);
  }

  private void loadImage(final String url, final ChatImageView/*ImageView*/ drawee, final View load,
                         boolean autoloadImage) {
    if (autoloadImage) {
      load.setVisibility(GONE);
      //FrescoHelper.INSTANCE.loadImageWithCustomization(drawee, url);
      Glide.with(activity).load(url).apply(optionsImg).into(new SimpleTarget<Drawable>() {
        @Override
        public void onResourceReady(Drawable resource, Transition<? super Drawable> transition) {
          int width = resource.getIntrinsicWidth();
          int height = resource.getIntrinsicHeight();
          //获取imageView的宽
          //int imageViewWidth= drawee.getWidth();
          int imageViewWidth;
          if(width>=height){
            imageViewWidth=300;
          }else {
            imageViewWidth=200;
          }
          //计算缩放比例
          float sy= (float) (imageViewWidth* 0.1)/(float) (width * 0.1);
          //计算图片等比例放大后的高
          int imageViewHeight= (int) (height * sy);
          FrameLayout.LayoutParams params = (FrameLayout.LayoutParams) drawee.getLayoutParams();
          params.height = imageViewHeight;
          params.width=imageViewWidth;
          drawee.setLayoutParams(params);
          drawee.setImageDrawable(resource);
          //drawee.requestLayout();
        }

        @Override
        public void onLoadFailed(@Nullable Drawable errorDrawable) {
          super.onLoadFailed(errorDrawable);
          drawee.setImageDrawable(activity.getResources().getDrawable(R.drawable.image_dummy));
        }
      });
        //Glide.with(activity).load(url).into(drawee);
      //return;
    }
    drawee.setOnClickListener(new OnClickListener() {
      @Override
      public void onClick(View v) {
        /*load.setVisibility(GONE);
        load.setOnClickListener(null);
        FrescoHelper.INSTANCE.loadImageWithCustomization(drawee, url);*/
        List<LocalMedia> list=new ArrayList<>();
        LocalMedia media=new LocalMedia();
        media.setPath(url);
        list.add(media);
        // 预览图片 可自定长按保存路径
        PictureSelector.create(activity).externalPicturePreview(0,list );

      }
    });
  }
}
