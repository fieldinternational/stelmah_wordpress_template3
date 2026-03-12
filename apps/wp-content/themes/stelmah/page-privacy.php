<?php
/**
 * プライバシーポリシー ページテンプレート
 * Template Name: Privacy Policy
 */
get_header(); ?>

<main class="unified-section pt-28 pb-20">
  <div class="max-w-6xl mx-auto px-6">
    <nav class="text-xs font-mono tracking-[0.4em] text-white/60">
      <a class="hover:text-white" href="<?php echo home_url('/'); ?>">HOME</a> <span class="mx-2">/</span> PRIVACY POLICY
    </nav>

    <div class="mt-8">
      <div class="font-mono text-xs tracking-[0.5em] text-neon-pink">PRIVACY</div>
      <h1 class="text-4xl md:text-5xl font-black tracking-tight mt-3"><?php the_title(); ?></h1>
    </div>

    <?php
      $has_content = false;
      if (have_posts()) {
        the_post();
        $raw = get_the_content();
        $stripped = trim(strip_tags(preg_replace('/<!--.*?-->/', '', $raw)));
        if ($stripped) {
          $has_content = true;
        }
      }
    ?>
    <section class="mt-12 rounded-3xl border border-white/10 bg-[#0f0f10] overflow-hidden">
      <?php if ($has_content) : ?>
        <div class="p-8 md:p-10 stelmah-content">
          <?php the_content(); ?>
        </div>
      <?php else : ?>
          <div class="p-8 md:p-10 border-b border-white/10">
            <div class="font-mono text-xs tracking-[0.4em] text-neon-pink">POLICY</div>
            <h2 class="text-2xl md:text-3xl font-bold mt-2">個人情報の取扱い</h2>
            <p class="text-white/70 mt-4 text-sm leading-relaxed">
              当ブログ（<?php echo esc_html(stelmah_get_option('site_name', get_bloginfo('name'))); ?>）では、以下のとおりプライバシーポリシーを定めます。
            </p>
          </div>
          <div class="p-8 md:p-10 space-y-10">
            <div>
              <h3 class="text-lg font-bold">1. 個人情報の利用目的</h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed">
                当ブログ(<?php echo esc_html(stelmah_get_option('site_name', get_bloginfo('name'))); ?>)では、お問い合わせや記事へのコメントの際、名前やメールアドレス等の個人情報を入力いただく場合がございます。<br>
                取得した個人情報は、お問い合わせに対する回答や必要な情報を電子メールなどでご連絡する場合に利用させていただくものであり、これらの目的以外では利用いたしません。
              </p>
            </div>

            <div>
              <h3 class="text-lg font-bold">2. コメントについて</h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed">
                当ブログへのコメントを残す際に、IP アドレスを収集しています。<br>
                これはブログの標準機能としてサポートされている機能で、スパムや荒らしへの対応以外にこのIPアドレスを使用することはありません。<br>
                なお、全てのコメントは管理人が事前にその内容を確認し、承認した上での掲載となります。あらかじめご了承ください。
              </p>
            </div>

            <div>
              <h3 class="text-lg font-bold">3. お問い合わせフォーム</h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed">
                当サイトのお問い合わせフォームから収集する個人データは、主にメールアドレス、名前、IPアドレスです。保持期間は約1年間ですが、マーケティング目的には使用しないことを言及しておきます。
              </p>
            </div>

            <div>
              <h3 class="text-lg font-bold">4. アナリティクス</h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed">
                当サイトではサイトの利用状況を把握するため、またサイト品質向上のためにGoogleによるアクセス解析ツール「Googleアナリティクス」を利用しております。このアクセス解析ツールはトラフィックデータ収集のためCookieを使用しています。このデータは個人データではなく匿名データです。また、Cookieにより収集した情報は広告をより効果的に作ったり、ユーザーエクスペリエンスを向上させたりとサービス改善のために利用されています。 取得したデータをどのように扱い、どのような形でプライバシーを保護するというのかについてはGoogleポリシー基づいて管理されます。詳しくは「ブラウザによって送信された情報の Google での利用について | Googleポリシーと規約」に記載されている内容からご覧いただけます。
              </p>
            </div>

            <div>
              <h3 class="text-lg font-bold">5. Cookie</h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed">
                当サイトが使用するGoogleアナリティクス・ASPにはトラフィックデータの収集のためにCookieを使用しています。このトラフィックデータは匿名で収集されており、個人を特定するものではありません。この機能はCookieを無効にすることで収集を拒否することが出来ますので、お使いのブラウザの設定をご確認ください。
              </p>
            </div>

            <div>
              <h3 class="text-lg font-bold">6. 他サイトからの埋め込みコンテンツ</h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed">
                このサイトの投稿には埋め込みコンテンツ (動画、画像、投稿など) が含まれます。他サイトからの埋め込みコンテンツは、訪問者がそのサイトを訪れた場合とまったく同じように振る舞います。
              </p>
            </div>

            <div>
              <h3 class="text-lg font-bold">7. データの共有先</h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed">
                当サイトは、皆さまのご承諾がない限り収集した個人データを第三者に提供いたしません。当サイト以外の企業/団体から皆さまに有益と思われる情報のお届けを代行する場合にも、皆さまのご承諾がない限り個人データはそうした企業/団体には開示・提供いたしません。
              </p>
              <p class="text-white/70 text-sm mt-3 leading-relaxed">
                ただし、皆さまが当サイト経由で当サイト以外の企業/団体に対して情報提供、サービス提供、商品の注文、応募、接触、仲介をご依頼いただいた場合や、それらの企業/団体が関係する展示会/セミナーの申し込みをされた場合、また広告掲載会社などへの資料請求の仲介を弊社に依頼された場合などには、当該企業/団体に個人データを開示・提供することがあります。
              </p>
            </div>

            <div>
              <h3 class="text-lg font-bold">8. プライバシーポリシーの変更</h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed">
                プライバシーポリシーは随時変更されます。個人情報の収集、利用及び/又は共有方法に重要な変更を行う場合には、このプライバシーポリシーが対象とするウェブサイトの目立つ場所に掲載することによってお知らせします。このプライバシーポリシーに関する重要な変更はこのプライバシーポリシーが対象とするウェブサイトに通知を掲載した日から有効となります。このプライバシーポリシーの変更は、当サイトからの変更通知前にお客様が提供した個人情報の利用に影響を及ぼすことになります。当サイトの個人情報の利用に関する変更に同意できない場合には、個人情報削除の意向を当サイトに通知しなければなりません。
              </p>
            </div>

            <div>
              <h3 class="text-lg font-bold">9. データの保護方法</h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed">
                当サイトはお客様のデータの安全と秘密保持を最も重要なものと考え、お客様のデータを不正アクセスや不正利用から保護するための技術的、管理上及び物理的セキュリティ対策を実施しています。当サイトは、適切な新しい技術や方法を検討するために適宜セキュリティ対策を見直しますが、100％安全なセキュリティ対策は存在しないことをご了承ください。
              </p>
            </div>

            <div>
              <h3 class="text-lg font-bold">10. 免責事項</h3>
              <p class="text-white/70 text-sm mt-3 leading-relaxed">
                当サイトからリンクやバナーなどによって他のサイトに移動された場合、移動先サイトで提供される情報、サービス等について一切の責任を負いません。当サイトのコンテンツ・情報につきまして、可能な限り正確な情報を掲載するよう努めておりますが、誤情報が入り込んだり、情報が古くなっていることもございます。当サイトに掲載された内容によって生じた損害等の一切の責任を負いかねますのでご了承ください。
              </p>
            </div>
          </div>
      <?php endif; ?>
    </section>

    <div class="mt-12">
      <a class="inline-flex items-center gap-2 bg-neon-pink text-black px-6 py-3 rounded-full font-bold hover:opacity-90 transition" href="<?php echo home_url('/'); ?>">
        HOMEへ戻る <i class="fa-solid fa-house"></i>
      </a>
    </div>
  </div>
</main>

<style>
.stelmah-content h2 { font-size: 1.5rem; font-weight: 700; margin-top: 2.5rem; color: #fff; }
.stelmah-content h2:first-child { margin-top: 0; }
.stelmah-content h3 { font-size: 1.125rem; font-weight: 700; margin-top: 2rem; color: #fff; }
.stelmah-content h3:first-child { margin-top: 0; }
.stelmah-content p { color: rgba(255,255,255,0.7); font-size: 0.875rem; margin-top: 0.75rem; line-height: 1.75; }
.stelmah-content ul, .stelmah-content ol { color: rgba(255,255,255,0.7); font-size: 0.875rem; margin-top: 0.75rem; padding-left: 1.25rem; line-height: 1.75; }
.stelmah-content ul { list-style: disc; }
.stelmah-content ol { list-style: decimal; }
.stelmah-content li { margin-top: 0.5rem; }
.stelmah-content hr { border-color: rgba(255,255,255,0.1); margin: 2rem 0; }
</style>

<?php get_footer(); ?>
