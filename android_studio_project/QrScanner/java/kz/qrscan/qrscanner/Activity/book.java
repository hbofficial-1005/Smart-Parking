package kz.qrscan.qrscanner.Activity;

import com.google.gson.annotations.SerializedName;


public class book {

    @SerializedName("spot")
    private String spot;
    @SerializedName("status")
    private String status;
    @SerializedName("user")
    private String user;

    @Override
    public String toString() {
        return "book{" + "spot=" + spot + '\'' + ", status='" + status + ", user='" + user + "}";
    }

    public String getSpot() {
        return spot;
    }

    public void setSpot(String spot) {
        this.spot = spot;
    }
    public String getStatus() {
        return status;
    }

    public String getUser() {
        return user;
    }

    public void setUser(String user) {
        this.user = user;
    }

    public void setStatus(String status) {
        this.status = status;
    }
}
