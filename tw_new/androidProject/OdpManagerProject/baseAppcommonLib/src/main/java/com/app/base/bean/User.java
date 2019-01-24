package com.app.base.bean;


import android.os.Parcel;
import android.os.Parcelable;

public class User implements Parcelable{
    public long id;
    public String firstname;
    public String lastname;
    public boolean isFollowing;


    private String name;

    protected User(Parcel in) {
        id = in.readLong();
        firstname = in.readString();
        lastname = in.readString();
        isFollowing = in.readByte() != 0;
        name = in.readString();
    }

    public static final Creator<User> CREATOR = new Creator<User>() {
        @Override
        public User createFromParcel(Parcel in) {
            return new User(in);
        }

        @Override
        public User[] newArray(int size) {
            return new User[size];
        }
    };

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public User() {
    }



    @Override
    public String toString() {
        return "User{" +
                "id=" + id +
                ", firstname='" + firstname + '\'' +
                ", lastname='" + lastname + '\'' +
                ", isFollowing=" + isFollowing +
                '}';
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeLong(id);
        dest.writeString(firstname);
        dest.writeString(lastname);
        dest.writeByte((byte) (isFollowing ? 1 : 0));
        dest.writeString(name);
    }
}
