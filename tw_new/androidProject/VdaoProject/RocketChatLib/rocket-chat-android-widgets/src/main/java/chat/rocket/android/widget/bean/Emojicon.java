
package chat.rocket.android.widget.bean;

/**
 * emoji表情的javabean
 */
public class Emojicon {
    private String name; //在网络传递中的值
    private byte[] code; //在系统中所代表的值
    private String value; //code转换为String的值

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public byte[] getCode() {
        return code;
    }

    public void setCode(byte[] code) {
        this.code = code;
    }

    public void setValue(String value) {
        this.value = value;
    }

    /**
     * @return code转换为String的值
     */
    public String getValue() {
        if (code == null) {
            return null;
        } else {
            return new String(code);
        }
    }
}
