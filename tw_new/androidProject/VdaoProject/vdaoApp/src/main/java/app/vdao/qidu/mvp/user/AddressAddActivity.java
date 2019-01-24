package app.vdao.qidu.mvp.user;

import android.content.ContentResolver;
import android.content.Intent;
import android.database.Cursor;
import android.net.Uri;
import android.os.Bundle;
import android.provider.ContactsContract;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.gzqx.common.base.AbsBaseActivity;
import app.vdao.qidu.R;

import app.vdao.qidu.bean.Address;
import butterknife.BindView;

/**
 * Created by Administrator on 2017/5/5.
 */

public class AddressAddActivity extends AbsBaseActivity implements View.OnClickListener{

    @BindView(R.id.header_right_btn)
    TextView titleRightText;
    @BindView(R.id.editName)
    EditText editName;
    @BindView(R.id.editPhone)
    EditText editPhone;
    @BindView(R.id.editDetail)
    EditText editDetail;
    @BindView(R.id.header_text)
    TextView titleCenter;
    @BindView(R.id.header_left_btn_img)
    ImageView titleLeftImage;
    @BindView(R.id.del)
    Button del;
    @BindView(R.id.choose)
    View choose;
    private Address address;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        titleCenter.setText("编辑地址");
        titleRightText.setText("保存");
        titleRightText.setVisibility(View.VISIBLE);
        titleRightText.setOnClickListener(this);
        titleLeftImage.setOnClickListener(this);
        choose.setOnClickListener(this);
        if (getIntent().getExtras() != null) {
            address = getIntent().getExtras().getParcelable("address");
            editName.setText(address.getRealname());
            editPhone.setText(address.getPhone());
            editDetail.setText(address.getAddress());
        } else {
            del.setVisibility(View.GONE);
        }
    }

    @Override
    protected int getContentViewID() {
        return R.layout.activity_address_add;
    }

    protected void save(boolean isDefault) {
        String name = editName.getText().toString().trim();
        String phone = editPhone.getText().toString().trim();
        String detail = editDetail.getText().toString().trim();
    }
    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.header_right_btn:
                //save(false);
                break;
            case R.id.header_left_btn_img:
                finish();
                break;
            case R.id.choose:
                /*Uri uri = Uri.parse("content://contacts/people");
                Intent intent = new Intent(Intent.ACTION_PICK, uri);
                startActivityForResult(intent, 0);*/

                Intent intent = new Intent(Intent.ACTION_INSERT_OR_EDIT);

                intent.setType("vnd.android.cursor.item/person");

                intent.setType("vnd.android.cursor.item/contact");

                intent.setType("vnd.android.cursor.item/raw_contact");

                intent.putExtra(android.provider.ContactsContract.Intents.Insert.PHONE_TYPE, 3);
                startActivityForResult(intent, 0);
                break;
            case R.id.def:
                //save(true);
                break;

            case R.id.del:
                ///del();
                break;
        }
    }


    /*跳转联系人列表的回调函数*/
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        switch (requestCode){
            case 0:
                if(data==null) { return; }
                //处理返回的data,获取选择的联系人信息
                Uri uri=data.getData(); String[] contacts=getPhoneContacts(uri);
                editName.setText(contacts[0]);
                editPhone.setText(contacts[1]);
                break;
        }
        super.onActivityResult(requestCode, resultCode, data);
    }
    private String[] getPhoneContacts(Uri uri){
        String[] contact=new String[2];
        //得到ContentResolver对象
        ContentResolver cr = getContentResolver();
        //取得电话本中开始一项的光标
        Cursor cursor=cr.query(uri,null,null,null,null);
        if(cursor!=null) {
            cursor.moveToFirst();
            //取得联系人姓名
            int nameFieldColumnIndex=cursor.getColumnIndex(ContactsContract.Contacts.DISPLAY_NAME);
            contact[0]=cursor.getString(nameFieldColumnIndex);
            //取得电话号码
            String ContactId = cursor.getString(cursor.getColumnIndex(ContactsContract.Contacts._ID));
            Cursor phone = cr.query(ContactsContract.CommonDataKinds.Phone.CONTENT_URI, null, ContactsContract.CommonDataKinds.Phone.CONTACT_ID + "=" + ContactId, null, null);
            if(phone != null){
                phone.moveToFirst();
                contact[1] = phone.getString(phone.getColumnIndex(ContactsContract.CommonDataKinds.Phone.NUMBER));
            }
            phone.close();
            cursor.close();
        } else {
            return null;
        }
        return contact;
    }
}
