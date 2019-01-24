package com.qidu.chat.helper;

import android.content.ContentResolver;
import android.content.Context;
import android.database.Cursor;
import android.net.Uri;
import android.os.ParcelFileDescriptor;
import android.provider.MediaStore;
import android.provider.OpenableColumns;
import android.support.annotation.Nullable;
import android.webkit.MimeTypeMap;

import org.json.JSONObject;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.UUID;
import chat.rocket.android.log.RCLog;
import chat.rocket.core.SyncState;
import chat.rocket.persistence.realm.models.ddp.RealmPublicSetting;
import chat.rocket.persistence.realm.models.internal.FileUploading;
import chat.rocket.persistence.realm.RealmHelper;

/**
 * utility class for uploading file.
 */
public class FileUploadHelper {

  private final Context context;
  private final RealmHelper realmHelper;

  public FileUploadHelper(Context context, RealmHelper realmHelper) {
    this.context = context;
    this.realmHelper = realmHelper;
  }

  /**
   * requestUploading file. returns id for observing progress.
   */
  public
  @Nullable
  String requestUploading(String roomId, Uri uri,boolean isExternal) {//isExternal是否调用系统的

    String[] projection=null;
    if(isExternal){
      projection=new String[]{MediaStore.Files.FileColumns.DATA};
    }
    try (Cursor cursor = context.getContentResolver().query(uri, projection, null, null, null)) {//4.4以下
      if (cursor != null && cursor.moveToFirst()) {
        String filename = cursor.getString(cursor.getColumnIndex(OpenableColumns.DISPLAY_NAME));
        long filesize = cursor.getLong(cursor.getColumnIndex(OpenableColumns.SIZE));
        String mimeType = context.getContentResolver().getType(uri);
        return insertRequestRecord(roomId, uri, filename, filesize, mimeType);
      } else if (ContentResolver.SCHEME_FILE.equals(uri.getScheme())) {
        String filename = uri.getLastPathSegment();
        long filesize = detectFileSizeFor(uri);
        String mimeType = MimeTypeMap.getSingleton()
            .getMimeTypeFromExtension(MimeTypeMap.getFileExtensionFromUrl(uri.toString()));
        return insertRequestRecord(roomId, uri, filename, filesize, mimeType);
      }
    }


    /*if ("file".equalsIgnoreCase(uri.getScheme())){//使用第三方应用打开
      String filename = uri.getLastPathSegment();
      long filesize = detectFileSizeFor(uri);
      String mimeType = MimeTypeMap.getSingleton()
              .getMimeTypeFromExtension(MimeTypeMap.getFileExtensionFromUrl(uri.toString()));
      return insertRequestRecord(roomId, uri, filename, filesize, mimeType);
    }
    if (Build.VERSION.SDK_INT > Build.VERSION_CODES.KITKAT) {//4.4以后
      String path = getPath(context, uri);
      File file=new File(path);
      String mimeType =getMimeType(file);
      String filename=file.getName();
      long filesize= 0;
      try {
        filesize = getFileSizes(file);
      } catch (Exception e) {
        e.printStackTrace();
      }
      return insertRequestRecord(roomId, uri, filename, filesize, mimeType);

    } else {//4.4以下下系统调用方法
      String path = getRealPathFromURI(uri);
      File file=new File(path);
      String mimeType =getMimeType(file);
      String filename=file.getName();
      long filesize= 0;
      try {
        filesize = getFileSizes(file);
      } catch (Exception e) {
        e.printStackTrace();
      }
      return insertRequestRecord(roomId, uri, filename, filesize, mimeType);
    }*/
    return null;
  }
  private long getFileSizes(File f) throws Exception
  {
    long s = 0;
    if (f.exists())
    {
      FileInputStream fis = null;
      fis = new FileInputStream(f);
      s = fis.available();
    }else{
      f.createNewFile();
      //System.out.println("文件不存在");
    }
    return s;
  }
  //获得获取文件的扩展名
  private String getExtension(final File file) {
    String suffix = "";
    String name = file.getName();
    final int idx = name.lastIndexOf(".");
    if (idx > 0) {
      suffix = name.substring(idx + 1);
    }
    return suffix;
  }
  //通过扩展名获取MIME类型
  private String getMimeType(final File file) {
    String extension = getExtension(file);
    return MimeTypeMap.getSingleton().getMimeTypeFromExtension(extension);
  }
  private String insertRequestRecord(String roomId,
                                     Uri uri, String filename, long filesize, String mimeType) {
    final String uplId = UUID.randomUUID().toString();
    final String storageType =
        RealmPublicSetting.getString(realmHelper, "FileUpload_Storage_Type", null);

    realmHelper.executeTransaction(realm ->
        realm.createOrUpdateObjectFromJson(FileUploading.class, new JSONObject()
            .put(FileUploading.ID, uplId)
            .put(FileUploading.SYNC_STATE, SyncState.NOT_SYNCED)
            .put(FileUploading.STORAGE_TYPE,
                TextUtils.isEmpty(storageType) ? JSONObject.NULL : storageType)
            .put(FileUploading.URI, uri.toString())
            .put(FileUploading.FILENAME, filename)
            .put(FileUploading.FILE_SIZE, filesize)
            .put(FileUploading.MIME_TYPE, mimeType)
            .put(FileUploading.ROOM_ID, roomId)
            .put(FileUploading.ERROR, JSONObject.NULL)
        )
    ).continueWith(new LogIfError());
    return uplId;
  }

  private long detectFileSizeFor(Uri uri) {
    ParcelFileDescriptor pfd = null;
    try {
      pfd = context.getContentResolver().openFileDescriptor(uri, "r");
      return Math.max(pfd.getStatSize(), 0);
    } catch (final FileNotFoundException exception) {
      RCLog.w(exception);
    } finally {
      if (pfd != null) {
        try {
          pfd.close();
        } catch (final IOException e) {
          // Do nothing.
        }
      }
    }
    return -1;
  }


}
