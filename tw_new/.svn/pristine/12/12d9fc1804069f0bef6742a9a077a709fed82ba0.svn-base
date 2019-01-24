package app.vdao.qidu.bean;

import android.os.Parcel;
import android.os.Parcelable;


public class Address implements Parcelable {
    private String id;
    private String user_id;
    private String address;
    private String realname;
    private String phone;
    private String code;
    private int is_default;
    private long add_time;

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getUser_id() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getRealname() {
        return realname;
    }

    public void setRealname(String realname) {
        this.realname = realname;
    }

    public String getPhone() {
        return phone;
    }

    public void setPhone(String phone) {
        this.phone = phone;
    }

    public String getCode() {
        return code;
    }

    public void setCode(String code) {
        this.code = code;
    }

    public int getIs_default() {
        return is_default;
    }

    public void setIs_default(int is_default) {
        this.is_default = is_default;
    }

    public long getAdd_time() {
        return add_time;
    }

    public void setAdd_time(long add_time) {
        this.add_time = add_time;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeString(this.id);
        dest.writeString(this.user_id);
        dest.writeString(this.address);
        dest.writeString(this.realname);
        dest.writeString(this.phone);
        dest.writeString(this.code);
        dest.writeInt(this.is_default);
        dest.writeLong(this.add_time);
    }

    public Address() {
    }

    protected Address(Parcel in) {
        this.id = in.readString();
        this.user_id = in.readString();
        this.address = in.readString();
        this.realname = in.readString();
        this.phone = in.readString();
        this.code = in.readString();
        this.is_default = in.readInt();
        this.add_time = in.readLong();
    }

    public static final Creator<Address> CREATOR = new Creator<Address>() {
        public Address createFromParcel(Parcel source) {
            return new Address(source);
        }

        public Address[] newArray(int size) {
            return new Address[size];
        }
    };
}
