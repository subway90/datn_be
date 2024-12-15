import NextAuth from "next-auth";
import GoogleProvider from "next-auth/providers/google";

export const authOptions = {
  providers: [
    GoogleProvider({
      clientId: process.env.NEXT_PUBLIC_GOOGLE_CLIENT_ID,
      clientSecret: process.env.NEXT_PUBLIC_GOOGLE_CLIENT_SECRET,
    }),
  ],
  callbacks: {
    async signIn({ account, profile }) {
      // Gọi API backend để kiểm tra/đăng ký tài khoản
      const response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/google/callback`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ token: account.id_token }),
      });

      const data = await response.json();
      if (data.status === "need_registration") {
        // Điều hướng đến trang đăng ký
        return `/register?email=${data.google_user.email}`;
      }
      return true; // Đăng nhập thành công
    },
  },
};

export default NextAuth(authOptions);
