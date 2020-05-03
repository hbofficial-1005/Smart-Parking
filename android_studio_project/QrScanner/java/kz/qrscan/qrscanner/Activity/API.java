package kz.qrscan.qrscanner.Activity;

import java.util.ArrayList;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.http.Body;
import retrofit2.http.Field;
import retrofit2.http.FieldMap;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Query;

public interface API {
    String BASE_URL = "http://insert.your.ip.here/bristlecone/";

    @GET("show.php/")
    Call<show> getStatus();

    @POST("book.php/")
    @FormUrlEncoded
    Call<book> book(@Field("spot") String spot, @Field("user") String user);

    @POST("free.php/")
    @FormUrlEncoded
    Call<free> free(@Field("spot") String spot, @Field("user") String user);



}