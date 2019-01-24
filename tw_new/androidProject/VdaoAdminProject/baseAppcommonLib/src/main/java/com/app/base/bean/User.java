package com.app.base.bean;

import android.os.Parcel;
import android.os.Parcelable;

import java.io.Serializable;

public class User implements Parcelable{
    /**
     * user_id : 1
     * user_name : yiye
     * user_password : 14e1b600b1fd579f47433b88e8d85291
     * payment_code : 14e1b600b1fd579f47433b88e8d85291
     * user_sex : 1
     * user_age : 23
     * user_realname :
     * user_city :
     * user_phone :
     * user_email : 531013076@qq.com
     * user_score : 100
     * user_balance : 1695.93
     * user_consume : 700.01
     * user_referee : 0
     * user_regtime : 1505888312
     * user_logtime : 1524030971
     * user_logip : 59.41.20.13
     * user_regip : 127.0.0.1
     * user_state : 1
     * is_shopman : 1
     * shopman_regtime : 1512097179
     * shopman_state : 1
     * referee_count : 0
     * user_commission : 18
     * weixin_openid :
     * qq_openid :
     * user_pic : upload/user/20171229100541138.png
     * weibo_uid :
     * user_position :
     * referee_consume : 1336.36
     * user_orders : 1,2,3,245
     * referee_orders : 1,2,32,31,30,3,4,5,6,7,8,9,10,4
     * user_ordercount : 5
     * referee_ordercount : 14
     * user_products : 19
     * referee_products : 15
     * update_time : 1513350395
     * user_fhbtotal : 16
     * user_shbtotal : 19
     * user_nickname : 王金山
     * user_erweima :
     * user_ispush : 1
     * shopman_income : 0
     * share_income : 0.00
     * user_selfoffice : 20
     * user_officecount : 1
     * user_refereeoffice :
     * referee_officecount : 0
     * alipay_number :
     * bank_number :
     * bank_name :
     * bank_province :
     * bank_city :
     * sub_bank :
     * alipay_realname :
     * bank_realname :
     */

    private String user_id;
    private String user_name;
    private String user_password;
    private String payment_code;
    private String user_sex;
    private String user_age;
    private String user_realname;
    private String user_city;
    private String user_phone;
    private String user_email;
    private String user_score;
    private String user_balance;
    private String user_consume;
    private String user_referee;
    private String user_regtime;
    private String user_logtime;
    private String user_logip;
    private String user_regip;
    private String user_state;
    private String is_shopman;
    private String shopman_regtime;
    private String shopman_state;
    private String referee_count;
    private String user_commission;
    private String weixin_openid;
    private String qq_openid;
    private String user_pic;
    private String weibo_uid;
    private String user_position;
    private String referee_consume;
    private String user_orders;
    private String referee_orders;
    private String user_ordercount;
    private String referee_ordercount;
    private String user_products;
    private String referee_products;
    private String update_time;
    private String user_fhbtotal;
    private String user_shbtotal;
    private String user_nickname;
    private String user_erweima;
    private String user_ispush;
    private String shopman_income;
    private String share_income;
    private String user_selfoffice;
    private String user_officecount;
    private String user_refereeoffice;
    private String referee_officecount;
    private String alipay_number;
    private String bank_number;
    private String bank_name;
    private String bank_province;
    private String bank_city;
    private String sub_bank;
    private String alipay_realname;
    private String bank_realname;

    protected User(Parcel in) {
        user_id = in.readString();
        user_name = in.readString();
        user_password = in.readString();
        payment_code = in.readString();
        user_sex = in.readString();
        user_age = in.readString();
        user_realname = in.readString();
        user_city = in.readString();
        user_phone = in.readString();
        user_email = in.readString();
        user_score = in.readString();
        user_balance = in.readString();
        user_consume = in.readString();
        user_referee = in.readString();
        user_regtime = in.readString();
        user_logtime = in.readString();
        user_logip = in.readString();
        user_regip = in.readString();
        user_state = in.readString();
        is_shopman = in.readString();
        shopman_regtime = in.readString();
        shopman_state = in.readString();
        referee_count = in.readString();
        user_commission = in.readString();
        weixin_openid = in.readString();
        qq_openid = in.readString();
        user_pic = in.readString();
        weibo_uid = in.readString();
        user_position = in.readString();
        referee_consume = in.readString();
        user_orders = in.readString();
        referee_orders = in.readString();
        user_ordercount = in.readString();
        referee_ordercount = in.readString();
        user_products = in.readString();
        referee_products = in.readString();
        update_time = in.readString();
        user_fhbtotal = in.readString();
        user_shbtotal = in.readString();
        user_nickname = in.readString();
        user_erweima = in.readString();
        user_ispush = in.readString();
        shopman_income = in.readString();
        share_income = in.readString();
        user_selfoffice = in.readString();
        user_officecount = in.readString();
        user_refereeoffice = in.readString();
        referee_officecount = in.readString();
        alipay_number = in.readString();
        bank_number = in.readString();
        bank_name = in.readString();
        bank_province = in.readString();
        bank_city = in.readString();
        sub_bank = in.readString();
        alipay_realname = in.readString();
        bank_realname = in.readString();
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

    public String getUser_id() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }

    public String getUser_name() {
        return user_name;
    }

    public void setUser_name(String user_name) {
        this.user_name = user_name;
    }

    public String getUser_password() {
        return user_password;
    }

    public void setUser_password(String user_password) {
        this.user_password = user_password;
    }

    public String getPayment_code() {
        return payment_code;
    }

    public void setPayment_code(String payment_code) {
        this.payment_code = payment_code;
    }

    public String getUser_sex() {
        return user_sex;
    }

    public void setUser_sex(String user_sex) {
        this.user_sex = user_sex;
    }

    public String getUser_age() {
        return user_age;
    }

    public void setUser_age(String user_age) {
        this.user_age = user_age;
    }

    public String getUser_realname() {
        return user_realname;
    }

    public void setUser_realname(String user_realname) {
        this.user_realname = user_realname;
    }

    public String getUser_city() {
        return user_city;
    }

    public void setUser_city(String user_city) {
        this.user_city = user_city;
    }

    public String getUser_phone() {
        return user_phone;
    }

    public void setUser_phone(String user_phone) {
        this.user_phone = user_phone;
    }

    public String getUser_email() {
        return user_email;
    }

    public void setUser_email(String user_email) {
        this.user_email = user_email;
    }

    public String getUser_score() {
        return user_score;
    }

    public void setUser_score(String user_score) {
        this.user_score = user_score;
    }

    public String getUser_balance() {
        return user_balance;
    }

    public void setUser_balance(String user_balance) {
        this.user_balance = user_balance;
    }

    public String getUser_consume() {
        return user_consume;
    }

    public void setUser_consume(String user_consume) {
        this.user_consume = user_consume;
    }

    public String getUser_referee() {
        return user_referee;
    }

    public void setUser_referee(String user_referee) {
        this.user_referee = user_referee;
    }

    public String getUser_regtime() {
        return user_regtime;
    }

    public void setUser_regtime(String user_regtime) {
        this.user_regtime = user_regtime;
    }

    public String getUser_logtime() {
        return user_logtime;
    }

    public void setUser_logtime(String user_logtime) {
        this.user_logtime = user_logtime;
    }

    public String getUser_logip() {
        return user_logip;
    }

    public void setUser_logip(String user_logip) {
        this.user_logip = user_logip;
    }

    public String getUser_regip() {
        return user_regip;
    }

    public void setUser_regip(String user_regip) {
        this.user_regip = user_regip;
    }

    public String getUser_state() {
        return user_state;
    }

    public void setUser_state(String user_state) {
        this.user_state = user_state;
    }

    public String getIs_shopman() {
        return is_shopman;
    }

    public void setIs_shopman(String is_shopman) {
        this.is_shopman = is_shopman;
    }

    public String getShopman_regtime() {
        return shopman_regtime;
    }

    public void setShopman_regtime(String shopman_regtime) {
        this.shopman_regtime = shopman_regtime;
    }

    public String getShopman_state() {
        return shopman_state;
    }

    public void setShopman_state(String shopman_state) {
        this.shopman_state = shopman_state;
    }

    public String getReferee_count() {
        return referee_count;
    }

    public void setReferee_count(String referee_count) {
        this.referee_count = referee_count;
    }

    public String getUser_commission() {
        return user_commission;
    }

    public void setUser_commission(String user_commission) {
        this.user_commission = user_commission;
    }

    public String getWeixin_openid() {
        return weixin_openid;
    }

    public void setWeixin_openid(String weixin_openid) {
        this.weixin_openid = weixin_openid;
    }

    public String getQq_openid() {
        return qq_openid;
    }

    public void setQq_openid(String qq_openid) {
        this.qq_openid = qq_openid;
    }

    public String getUser_pic() {
        return user_pic;
    }

    public void setUser_pic(String user_pic) {
        this.user_pic = user_pic;
    }

    public String getWeibo_uid() {
        return weibo_uid;
    }

    public void setWeibo_uid(String weibo_uid) {
        this.weibo_uid = weibo_uid;
    }

    public String getUser_position() {
        return user_position;
    }

    public void setUser_position(String user_position) {
        this.user_position = user_position;
    }

    public String getReferee_consume() {
        return referee_consume;
    }

    public void setReferee_consume(String referee_consume) {
        this.referee_consume = referee_consume;
    }

    public String getUser_orders() {
        return user_orders;
    }

    public void setUser_orders(String user_orders) {
        this.user_orders = user_orders;
    }

    public String getReferee_orders() {
        return referee_orders;
    }

    public void setReferee_orders(String referee_orders) {
        this.referee_orders = referee_orders;
    }

    public String getUser_ordercount() {
        return user_ordercount;
    }

    public void setUser_ordercount(String user_ordercount) {
        this.user_ordercount = user_ordercount;
    }

    public String getReferee_ordercount() {
        return referee_ordercount;
    }

    public void setReferee_ordercount(String referee_ordercount) {
        this.referee_ordercount = referee_ordercount;
    }

    public String getUser_products() {
        return user_products;
    }

    public void setUser_products(String user_products) {
        this.user_products = user_products;
    }

    public String getReferee_products() {
        return referee_products;
    }

    public void setReferee_products(String referee_products) {
        this.referee_products = referee_products;
    }

    public String getUpdate_time() {
        return update_time;
    }

    public void setUpdate_time(String update_time) {
        this.update_time = update_time;
    }

    public String getUser_fhbtotal() {
        return user_fhbtotal;
    }

    public void setUser_fhbtotal(String user_fhbtotal) {
        this.user_fhbtotal = user_fhbtotal;
    }

    public String getUser_shbtotal() {
        return user_shbtotal;
    }

    public void setUser_shbtotal(String user_shbtotal) {
        this.user_shbtotal = user_shbtotal;
    }

    public String getUser_nickname() {
        return user_nickname;
    }

    public void setUser_nickname(String user_nickname) {
        this.user_nickname = user_nickname;
    }

    public String getUser_erweima() {
        return user_erweima;
    }

    public void setUser_erweima(String user_erweima) {
        this.user_erweima = user_erweima;
    }

    public String getUser_ispush() {
        return user_ispush;
    }

    public void setUser_ispush(String user_ispush) {
        this.user_ispush = user_ispush;
    }

    public String getShopman_income() {
        return shopman_income;
    }

    public void setShopman_income(String shopman_income) {
        this.shopman_income = shopman_income;
    }

    public String getShare_income() {
        return share_income;
    }

    public void setShare_income(String share_income) {
        this.share_income = share_income;
    }

    public String getUser_selfoffice() {
        return user_selfoffice;
    }

    public void setUser_selfoffice(String user_selfoffice) {
        this.user_selfoffice = user_selfoffice;
    }

    public String getUser_officecount() {
        return user_officecount;
    }

    public void setUser_officecount(String user_officecount) {
        this.user_officecount = user_officecount;
    }

    public String getUser_refereeoffice() {
        return user_refereeoffice;
    }

    public void setUser_refereeoffice(String user_refereeoffice) {
        this.user_refereeoffice = user_refereeoffice;
    }

    public String getReferee_officecount() {
        return referee_officecount;
    }

    public void setReferee_officecount(String referee_officecount) {
        this.referee_officecount = referee_officecount;
    }

    public String getAlipay_number() {
        return alipay_number;
    }

    public void setAlipay_number(String alipay_number) {
        this.alipay_number = alipay_number;
    }

    public String getBank_number() {
        return bank_number;
    }

    public void setBank_number(String bank_number) {
        this.bank_number = bank_number;
    }

    public String getBank_name() {
        return bank_name;
    }

    public void setBank_name(String bank_name) {
        this.bank_name = bank_name;
    }

    public String getBank_province() {
        return bank_province;
    }

    public void setBank_province(String bank_province) {
        this.bank_province = bank_province;
    }

    public String getBank_city() {
        return bank_city;
    }

    public void setBank_city(String bank_city) {
        this.bank_city = bank_city;
    }

    public String getSub_bank() {
        return sub_bank;
    }

    public void setSub_bank(String sub_bank) {
        this.sub_bank = sub_bank;
    }

    public String getAlipay_realname() {
        return alipay_realname;
    }

    public void setAlipay_realname(String alipay_realname) {
        this.alipay_realname = alipay_realname;
    }

    public String getBank_realname() {
        return bank_realname;
    }

    public void setBank_realname(String bank_realname) {
        this.bank_realname = bank_realname;
    }


    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeString(user_id);
        dest.writeString(user_name);
        dest.writeString(user_password);
        dest.writeString(payment_code);
        dest.writeString(user_sex);
        dest.writeString(user_age);
        dest.writeString(user_realname);
        dest.writeString(user_city);
        dest.writeString(user_phone);
        dest.writeString(user_email);
        dest.writeString(user_score);
        dest.writeString(user_balance);
        dest.writeString(user_consume);
        dest.writeString(user_referee);
        dest.writeString(user_regtime);
        dest.writeString(user_logtime);
        dest.writeString(user_logip);
        dest.writeString(user_regip);
        dest.writeString(user_state);
        dest.writeString(is_shopman);
        dest.writeString(shopman_regtime);
        dest.writeString(shopman_state);
        dest.writeString(referee_count);
        dest.writeString(user_commission);
        dest.writeString(weixin_openid);
        dest.writeString(qq_openid);
        dest.writeString(user_pic);
        dest.writeString(weibo_uid);
        dest.writeString(user_position);
        dest.writeString(referee_consume);
        dest.writeString(user_orders);
        dest.writeString(referee_orders);
        dest.writeString(user_ordercount);
        dest.writeString(referee_ordercount);
        dest.writeString(user_products);
        dest.writeString(referee_products);
        dest.writeString(update_time);
        dest.writeString(user_fhbtotal);
        dest.writeString(user_shbtotal);
        dest.writeString(user_nickname);
        dest.writeString(user_erweima);
        dest.writeString(user_ispush);
        dest.writeString(shopman_income);
        dest.writeString(share_income);
        dest.writeString(user_selfoffice);
        dest.writeString(user_officecount);
        dest.writeString(user_refereeoffice);
        dest.writeString(referee_officecount);
        dest.writeString(alipay_number);
        dest.writeString(bank_number);
        dest.writeString(bank_name);
        dest.writeString(bank_province);
        dest.writeString(bank_city);
        dest.writeString(sub_bank);
        dest.writeString(alipay_realname);
        dest.writeString(bank_realname);
    }
}
