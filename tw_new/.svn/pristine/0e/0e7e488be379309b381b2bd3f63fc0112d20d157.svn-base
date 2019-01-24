package choose.lm.com.fileselector.model;

import android.os.Parcel;
import android.os.Parcelable;

/**
 * Created by Administrator on 2016/11/28 0028.
 */
public class FileInfo implements Parcelable {
    protected FileInfo(Parcel in) {
        file_id = in.readInt();
        id = in.readInt();
        file_name = in.readString();
        file_path = in.readString();
        file_type = in.readString();
        file_size = in.readLong();
        file_thumnbail = in.readString();
        file_modified_time = in.readLong();
        is_thumnbail = in.readByte() != 0;
        is_select = in.readByte() != 0;
        source_name = in.readString();
        path = in.readString();
        progress = in.readString();
        uploadFinish = in.readByte() != 0;
        uploadFailure = in.readByte() != 0;
        fileUrl = in.readString();
    }

    public static final Creator<FileInfo> CREATOR = new Creator<FileInfo>() {
        @Override
        public FileInfo createFromParcel(Parcel in) {
            return new FileInfo(in);
        }

        @Override
        public FileInfo[] newArray(int size) {
            return new FileInfo[size];
        }
    };

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeInt(file_id);
        dest.writeInt(id);
        dest.writeString(file_name);
        dest.writeString(file_path);
        dest.writeString(file_type);
        dest.writeLong(file_size);
        dest.writeString(file_thumnbail);
        dest.writeLong(file_modified_time);
        dest.writeByte((byte) (is_thumnbail ? 1 : 0));
        dest.writeByte((byte) (is_select ? 1 : 0));
        dest.writeString(source_name);
        dest.writeString(path);
        dest.writeString(progress);
        dest.writeByte((byte) (uploadFinish ? 1 : 0));
        dest.writeByte((byte) (uploadFailure ? 1 : 0));
        dest.writeString(fileUrl);
    }

    public interface FileType {//文件类型
        String VIDEO = "video";
        String IMAGE = "image";
        String RAR = "rar";
        String EXCEL = "excel";
        String PDF = "pdf";
        String PPT = "ppt";
        String WORD = "word";
        String MP3 = "mp3";
        String TEXT = "txt";
    }
    private int file_id;
    private int id;
    private String file_name;
    private String file_path;
    private String file_type;
    private long file_size;
    private String file_thumnbail;
    private long file_modified_time;
    private boolean is_thumnbail;
    private boolean is_select=false;


    /*后台返回的字段*/
    private String source_name;
    //private String file_name;
    private String path;

    public String getSource_name() {
        return source_name;
    }

    public void setSource_name(String source_name) {
        this.source_name = source_name;
    }

    public String getPath() {
        return path;
    }

    public void setPath(String path) {
        this.path = path;
    }

    public String getFileUrl() {
        return fileUrl;
    }

    public void setFileUrl(String fileUrl) {
        this.fileUrl = fileUrl;
    }

    private String progress;
    private boolean uploadFinish;
    private boolean uploadFailure=false;//此标记为true时表示需要重新上传 默认为false 表示还没上传

    private String fileUrl;//图片上传成功之后的地址

    public boolean isIs_select() {
        return is_select;
    }

    public String getProgress() {
        return progress;
    }

    public void setProgress(String progress) {
        this.progress = progress;
    }

    public boolean isUploadFinish() {
        return uploadFinish;
    }

    public void setUploadFinish(boolean uploadFinish) {
        this.uploadFinish = uploadFinish;
    }

    public boolean isUploadFailure() {
        return uploadFailure;
    }

    public void setUploadFailure(boolean uploadFailure) {
        this.uploadFailure = uploadFailure;
    }

    public FileInfo() {
    }

    public FileInfo(int id, int file_id, String file_name, String file_path, long file_size, long file_modified_time, boolean is_thumnbail, String file_type) {
        this.id = id;
        this.file_id = file_id;
        this.file_name = file_name;
        this.file_path = file_path;
        this.file_size = file_size;
        this.file_modified_time = file_modified_time;
        this.is_thumnbail = is_thumnbail;
        this.file_type = file_type;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public boolean is_select() {
        return is_select;
    }

    public void setIs_select(boolean is_select) {
        this.is_select = is_select;
    }

    public int getFile_id() {
        return file_id;
    }

    public void setFile_id(int file_id) {
        this.file_id = file_id;
    }

    public boolean is_thumnbail() {
        return is_thumnbail;
    }

    public void setIs_thumnbail(boolean is_thumnbail) {
        this.is_thumnbail = is_thumnbail;
    }

    public String getFile_name() {
        return file_name;
    }

    public void setFile_name(String file_name) {
        this.file_name = file_name;
    }

    public String getFile_path() {
        return file_path;
    }

    public void setFile_path(String file_path) {
        this.file_path = file_path;
    }

    public long getFile_size() {
        return file_size;
    }

    public void setFile_size(long file_size) {
        this.file_size = file_size;
    }

    public String getFile_thumnbail() {
        return file_thumnbail;
    }

    public void setFile_thumnbail(String file_thumnbail) {
        this.file_thumnbail = file_thumnbail;
    }

    public long getFile_modified_time() {
        return file_modified_time;
    }

    public void setFile_modified_time(long file_modified_time) {
        this.file_modified_time = file_modified_time;
    }

    public String getFile_type() {
        return file_type;
    }

    public void setFile_type(String file_type) {
        this.file_type = file_type;
    }



}
