package com.qidu.chat.fragment.chatroom;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.luck.picture.lib.PictureSelector;
import com.luck.picture.lib.compress.Luban;
import com.luck.picture.lib.config.PictureConfig;
import com.luck.picture.lib.config.PictureMimeType;
import com.luck.picture.lib.entity.LocalMedia;
import com.qidu.chat.fragment.AbstractFragment;

import com.qidu.chat.R;

import java.util.ArrayList;
import java.util.List;

import chat.rocket.android.widget.RoomToolbar;
import chat.rocket.core.models.User;

abstract class AbstractChatRoomFragment extends AbstractFragment {
  private RoomToolbar roomToolbar;

  @Nullable
  @Override
  public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
    roomToolbar = getActivity().findViewById(R.id.activity_main_toolbar);
    return super.onCreateView(inflater, container, savedInstanceState);
  }

  protected void setToolbarTitle(CharSequence title) {
    roomToolbar.setTitle(title);
  }

  protected void showToolbarPrivateChannelIcon() {
    roomToolbar.showPrivateChannelIcon();
  }

  protected void showToolbarPublicChannelIcon() {
    roomToolbar.showPublicChannelIcon();
  }

  protected void showToolbarLivechatChannelIcon() {
    roomToolbar.showLivechatChannelIcon();
  }

  protected void showToolbarUserStatuslIcon(@Nullable String status) {
    if (status == null) {
      roomToolbar.showUserStatusIcon(RoomToolbar.STATUS_OFFLINE);
    } else {
      switch (status) {
        case User.STATUS_ONLINE:
          roomToolbar.showUserStatusIcon(RoomToolbar.STATUS_ONLINE);
          break;
        case User.STATUS_BUSY:
          roomToolbar.showUserStatusIcon(RoomToolbar.STATUS_BUSY);
          break;
        case User.STATUS_AWAY:
          roomToolbar.showUserStatusIcon(RoomToolbar.STATUS_AWAY);
          break;
        default:
          roomToolbar.showUserStatusIcon(RoomToolbar.STATUS_OFFLINE);
          break;
      }
    }
  }

  protected int aspect_ratio_x=1,aspect_ratio_y=1;
  protected boolean mode = false;// 启动相册模式
  protected int maxVideoSeconds=16;//限制和选择视频的最大时长 秒  不包括16秒
  private int selectMode = PictureConfig.SINGLE;//单选
  private int maxSelectNum = 9;// 图片最大可选数量
  protected int chooseMode = PictureMimeType.ofAll();
  protected boolean isShowCamera=false;
  //进入相册
  protected void openGallery(RoomFragment fragment,List<LocalMedia> commonList){
    PictureSelector.create(fragment)
            .openGallery(chooseMode)// 全部.PictureMimeType.ofAll()、图片.ofImage()、视频.ofVideo()、音频.ofAudio()
            .theme(R.style.picture_default_style)// 主题样式设置 具体参考 values/styles   用法：R.style.picture.white.style
            .maxSelectNum(maxSelectNum)// 最大图片选择数量
            .minSelectNum(1)// 最小选择数量
            .imageSpanCount(4)// 每行显示个数
            .selectionMode(selectMode)// 多选 or 单选
            .previewImage(true)// 是否可预览图片
            .previewVideo(true)// 是否可预览视频
            .enablePreviewAudio(false) // 是否可播放音频
            .compressGrade(Luban.THIRD_GEAR)// luban压缩档次，默认3档 Luban.FIRST_GEAR、Luban.CUSTOM_GEAR
            .isCamera(isShowCamera)// 是否显示拍照按钮
            .isZoomAnim(true)// 图片列表点击 缩放效果 默认true
            //.setOutputCameraPath("/CustomPath")// 自定义拍照保存路径
            .enableCrop(true)// 是否裁剪
            .compress(true)// 是否压缩
            .compressMode(PictureConfig.SYSTEM_COMPRESS_MODE)//系统自带 or 鲁班压缩 PictureConfig.SYSTEM_COMPRESS_MODE or LUBAN_COMPRESS_MODE
            //.sizeMultiplier(0.5f)// glide 加载图片大小 0~1之间 如设置 .glideOverride()无效
            .glideOverride(160, 160)// glide 加载宽高，越小图片列表越流畅，但会影响列表图片浏览的清晰度
            //.withAspectRatio(aspect_ratio_x, aspect_ratio_y)// 裁剪比例 如16:9 3:2 3:4 1:1 可自定义
            .hideBottomControls(true)// 是否显示uCrop工具栏，默认不显示
            .isGif(true)// 是否显示gif图片
            .freeStyleCropEnabled(true)// 裁剪框是否可拖拽
            .circleDimmedLayer(false)// 是否圆形裁剪
            .showCropFrame(true)// 是否显示裁剪矩形边框 圆形裁剪时建议设为false
            .showCropGrid(false)// 是否显示裁剪矩形网格 圆形裁剪时建议设为false
            .openClickSound(false)// 是否开启点击声音
            .selectionMedia(commonList)// 是否传入已选图片
            //.previewEggs(false)// 预览图片时 是否增强左右滑动图片体验(图片滑动一半即可看到上一张是否选中)
            //.cropCompressQuality(90)// 裁剪压缩质量 默认100
            //.compressMaxKB()//压缩最大值kb compressGrade()为Luban.CUSTOM_GEAR有效
            //.compressWH() // 压缩宽高比 compressGrade()为Luban.CUSTOM_GEAR有效
            //.cropWH()// 裁剪宽高比，设置如果大于图片本身宽高则无效
            //.rotateEnabled() // 裁剪是否可旋转图片
            //.scaleEnabled()// 裁剪是否可放大缩小图片
            .videoQuality(0)// 视频录制质量 0 or 1
            .videoMaxSecond(10)// 显示多少秒以内的视频or音频也可适用 int
            .videoMinSecond(1)// 显示多少秒以内的视频or音频也可适用 int
            .recordVideoSecond(maxVideoSeconds)//录制视频秒数 默认60s
            .forResult(PictureConfig.CHOOSE_REQUEST);//结果回调onActivityResult code
  }


  // 单独拍照
  protected void openCamera(RoomFragment fragment,List<LocalMedia> selectList){
    PictureSelector.create(fragment)
            .openCamera(chooseMode)
            .theme(R.style.picture_default_style)
            .maxSelectNum(maxSelectNum)
            .minSelectNum(1)
            .selectionMode(selectMode)
            .previewImage(true)
            .previewVideo(true)
            .enablePreviewAudio(true) // 是否可播放音频
            .compressGrade(Luban.THIRD_GEAR)
            .isCamera(true)
            .enableCrop(true)
            .compress(true)
            .compressMode(PictureConfig.SYSTEM_COMPRESS_MODE)
            .glideOverride(160, 160)
            //.withAspectRatio(aspect_ratio_x, aspect_ratio_y)
            .hideBottomControls(true)
            .isGif(false)
            .freeStyleCropEnabled(false)
            .circleDimmedLayer(false)
            .showCropFrame(true)
            .showCropGrid(false)
            .openClickSound(false)
            .selectionMedia(selectList)
            .videoQuality(0)// 视频录制质量 0 or 1
            .videoMaxSecond(10)// 显示多少秒以内的视频or音频也可适用 int
            .videoMinSecond(1)// 显示多少秒以内的视频or音频也可适用 int
            .recordVideoSecond(maxVideoSeconds)//录制视频秒数 默认60s
            .forResult(PictureConfig.CHOOSE_REQUEST);
  }
}