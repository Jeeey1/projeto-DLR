<?php 
// 1. Conexão com o banco de dados
include_once "./includes/conexao.php";
$pdo = (new Conexao())->conectar();

// 2. Busca os últimos 3 posts
$qryBlog = "SELECT p.id, p.titulo, p.imagem, p.data_criacao, c.nome as nome_categoria 
            FROM posts p 
            LEFT JOIN categorias c ON p.categoria = c.id 
            ORDER BY p.id DESC 
            LIMIT 3";
$stmtBlog = $pdo->query($qryBlog);
$postsPublicos = $stmtBlog->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dr. Daniel | Psicólogo & Neuropsicólogo</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="/projeto-DLR/public/css/common.css">
  <link rel="stylesheet" href="/projeto-DLR/public/css/index_style.css">
</head>

<body>
  <?php
  include "./includes/header.php";
  ?>
  <section id="home">
    <div class="home-content">

      <div class="hero-content">
        <div class="hero-badge"><span data-lang="pt">Psicólogo & Neuropsicólogo Clínico</span><span
            data-lang="en">Clinical
            Psychologist & Neuropsychologist</span></div>
        <h1 class="hero-title">
          <span data-lang="pt">Cuidado <em>especializado</em><br>para sua saúde<br>mental e cognitiva</span>
          <span data-lang="en">Specialized <em>care</em><br>for your mental<br>and cognitive health</span>
        </h1>
        <p class="hero-subtitle">
          <span data-lang="pt">Atendimentos presenciais em Ribeirão Preto e online para o Brasil e mundo. Mais de 10
            anos
            de experiência clínica e de pesquisa.</span>
          <span data-lang="en">In-person sessions in Ribeirão Preto and online for Brazil and worldwide. Over 10 years
            of
            clinical and research experience.</span>
        </p>
        <div class="hero-actions">
          <a href="https://www.doctoralia.com.br/daniel-lataro-de-robbio/psicologo/ribeirao-preto" target="_blank"
            class="btn-primary">
            <span data-lang="pt">Agendar Consulta</span><span data-lang="en">Book a Session</span>
          </a>
          <a href="#sobre" class="btn-secondary">
            <span data-lang="pt">Saiba mais</span><span data-lang="en">Learn more</span>
          </a>
        </div>
        <div class="hero-stats">
          <div>
            <div class="stat-num">10+</div>
            <div class="stat-label"><span data-lang="pt">Anos de experiência</span><span data-lang="en">Years
                experience</span></div>
          </div>
          <div>
            <div class="stat-num">2</div>
            <div class="stat-label"><span data-lang="pt">Especialidades</span><span data-lang="en">Specialties</span>
            </div>
          </div>
          <div>
            <div class="stat-num">BR</div>
            <div class="stat-label"><span data-lang="pt">& Internacional</span><span data-lang="en">&
                International</span>
            </div>
          </div>
        </div>
      </div>
      <div class="hero-image">
        <div style="position:relative;">
          <div class="hero-deco"></div>
          <div class="hero-deco2"></div>
          <div class="hero-photo-frame">
            <div class="hero-photo-placeholder">
              <svg class="hero-photo-svg" viewBox="0 0 120 160" width="120" fill="none" stroke="rgba(201,168,76,.5)"
                stroke-width="1">
                <circle cx="60" cy="50" r="28" />
                <path d="M8 140 Q8 100 60 95 Q112 100 112 140" />
              </svg>
            </div>
            <div class="hero-photo-caption">
              <h3>Dr. Daniel</h3>
              <p>CRP 06/130646 · Ribeirão Preto, SP</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <section id="sobre">
    <div class="sobre-content">
      <div class="reveal">
        <div class="section-eyebrow"><span data-lang="pt">Sobre o Profissional</span><span data-lang="en">About</span>
        </div>
        <h2 class="section-title">
          <span data-lang="pt">Daniel Lataro<br><em>De Robbio</em></span>
          <span data-lang="en">Daniel Lataro<br><em>De Robbio</em></span>
        </h2>
        <p class="section-body">
          <span data-lang="pt">Psicólogo e Neuropsicólogo com mais de 10 anos de experiência clínica e de pesquisa,
            atuando com pessoas de diferentes idades e contextos, tanto no Brasil quanto online para o mundo
            todo.</span>
          <span data-lang="en">Psychologist and Neuropsychologist with over 10 years of clinical and research
            experience,
            working with people of different ages and backgrounds, both in Brazil and online worldwide.</span>
        </p>
        <p class="section-body">
          <span data-lang="pt">Sou registrado no Conselho Federal de Psicologia (CRP 06/130646) e recebo em meu
            consultório no bairro Alto da Boa Vista, em Ribeirão Preto, bem como em atendimentos online que conectam
            você
            de qualquer lugar com cuidado especializado.</span>
          <span data-lang="en">Registered with the Federal Council of Psychology (CRP 06/130646), with an office in Alto
            da Boa Vista, Ribeirão Preto, and online appointments available worldwide.</span>
        </p>
        <span class="crp-badge">CRP 06/130646</span>
      </div>
      <div class="sobre-card reveal" style="transition-delay:.15s">
        <div class="section-eyebrow"><span data-lang="pt">Missão & Valores</span><span data-lang="en">Mission &
            Values</span></div>
        <p class="section-body" style="margin-top:0">
          <span data-lang="pt">Promover saúde mental e desenvolvimento cognitivo por meio de atendimentos e avaliações
            baseados em evidências científicas, contribuindo para o bem-estar e a autonomia dos indivíduos.</span>
          <span data-lang="en">To promote mental health and cognitive development through evidence-based assessments and
            interventions, contributing to individual well-being and autonomy.</span>
        </p>
        <div class="sobre-values">
          <div class="value-item">
            <div class="value-dot"></div>
            <p><strong><span data-lang="pt">Ética e Responsabilidade</span><span data-lang="en">Ethics &
                  Responsibility</span></strong><span data-lang="pt">Princípios científicos e respeito
                humano</span><span data-lang="en">Scientific principles and human respect</span></p>
          </div>
          <div class="value-item">
            <div class="value-dot"></div>
            <p><strong><span data-lang="pt">Acolhimento e Empatia</span><span data-lang="en">Warmth &
                  Empathy</span></strong><span data-lang="pt">Cuidado genuíno em cada atendimento</span><span
                data-lang="en">Genuine care in every session</span></p>
          </div>
          <div class="value-item">
            <div class="value-dot"></div>
            <p><strong><span data-lang="pt">Excelência Técnica</span><span data-lang="en">Technical
                  Excellence</span></strong><span data-lang="pt">Práticas baseadas em evidências</span><span
                data-lang="en">Evidence-based practices</span></p>
          </div>
          <div class="value-item">
            <div class="value-dot"></div>
            <p><strong><span data-lang="pt">Desenvolvimento Contínuo</span><span data-lang="en">Continuous
                  Growth</span></strong><span data-lang="pt">Atualização e crescimento constantes</span><span
                data-lang="en">Constant learning and improvement</span></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="servicos">
    <div class="servicos-content">
      <div class="reveal">
        <div class="section-eyebrow"><span data-lang="pt">O que ofereço</span><span data-lang="en">What I offer</span>
        </div>
        <div class="" style="  text-align: center;">

          <div class="d-flex justify-content-start mb-3">
            <h2 class="section-title"><span data-lang="pt">Serviços <em>especializados</em></span><span
                data-lang="en">Specialized <em>services</em></span></h2>
          </div>
        </div>
      </div>
      <div class="services-grid">
        <div class="service-card reveal">
          <div class="service-num">01</div>
          <div class="service-icon">
            <svg viewBox="0 0 24 24">
              <path d="M12 2a9 9 0 1 0 0 18A9 9 0 0 0 12 2z" />
              <path d="M12 8v4l3 3" />
            </svg>
          </div>
          <h3 class="service-title"><span data-lang="pt">Neuropsicologia</span><span
              data-lang="en">Neuropsychology</span>
          </h3>
          <p class="service-desc"><span data-lang="pt">Avaliação neuropsicológica completa para mapeamento das funções
              cognitivas, com laudos detalhados e plano de intervenção.</span><span data-lang="en">Complete
              neuropsychological assessment for mapping cognitive functions, with detailed reports and intervention
              plans.</span></p>
          <ul class="service-list">
            <li><span data-lang="pt">Avaliação neuropsicológica</span><span data-lang="en">Neuropsychological
                assessment</span></li>
            <li><span data-lang="pt">Métodos baseados em evidências</span><span data-lang="en">Evidence-based
                methods</span></li>
            <li><span data-lang="pt">Laudos e aplicações</span><span data-lang="en">Reports and applications</span></li>
            <li><span data-lang="pt">Reabilitação cognitiva</span><span data-lang="en">Cognitive rehabilitation</span>
            </li>
          </ul>
        </div>
        <div class="service-card reveal" style="transition-delay:.1s">
          <div class="service-num">02</div>
          <div class="service-icon">
            <svg viewBox="0 0 24 24">
              <path
                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
            </svg>
          </div>
          <h3 class="service-title"><span data-lang="pt">Psicoterapia</span><span data-lang="en">Psychotherapy</span>
          </h3>
          <p class="service-desc"><span data-lang="pt">Atendimento psicoterápico individual com abordagem baseada em
              evidências, voltado para o desenvolvimento emocional e bem-estar.</span><span data-lang="en">Individual
              psychotherapy with an evidence-based approach, focused on emotional development and well-being.</span></p>
          <ul class="service-list">
            <li><span data-lang="pt">Abordagem terapêutica individualizada</span><span data-lang="en">Individualized
                therapeutic approach</span></li>
            <li><span data-lang="pt">Especialidades clínicas</span><span data-lang="en">Clinical specialties</span></li>
            <li><span data-lang="pt">Presencial e online</span><span data-lang="en">In-person and online</span></li>
            <li><span data-lang="pt">Todas as idades</span><span data-lang="en">All ages</span></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section id="blog">
    <div class="blog-content">
      <div class="blog-header reveal">
        <div>
          <div class="section-eyebrow"><span data-lang="pt">Conteúdo educativo</span><span data-lang="en">Educational
              content</span></div>
          <h2 class="section-title"><span data-lang="pt">Artigos & <em>Publicações</em></span><span
              data-lang="en">Articles & <em>Publications</em></span></h2>
        </div>
        <a href="blog.php" class="btn-secondary" style="align-self:flex-end"><span data-lang="pt">Ver todos</span><span
            data-lang="en">See all</span></a>
      </div>

      <div class="blog-grid">
        <?php 
      // Loop travado em 3 para manter o Grid sempre perfeito
      for ($i = 0; $i < 3; $i++) {
          $delay = $i * 0.1; // Cria o efeito cascata do reveal (0s, 0.1s, 0.2s)
          
          if (isset($postsPublicos[$i])) {
              $p = $postsPublicos[$i];
              
              // Ajusta imagem (se o caminho já estiver salvo no banco como relativo, ex: src/img/posts/foto.jpg)
              $imagem = !empty($p['imagem']) ? $p['imagem'] : '';
              $bgStyle = $imagem ? "background-image: url('".$imagem."'); background-size: cover; background-position: center;" : "";
              
              // Ajusta categoria e data
              $categoria = !empty($p['nome_categoria']) ? ucfirst($p['nome_categoria']) : 'Sem categoria';
              $dataFmt = (new DateTime($p['data_criacao']))->format('d/m/Y');
              
              // Renderiza o POST REAL
              echo '<div class="blog-card reveal" style="position: relative; transition-delay:'.$delay.'s">';
              echo '  <div class="blog-thumb" style="'.$bgStyle.'">';
              
              // Se não tiver foto, exibe o símbolo Psi padrão do seu CSS
              if (!$imagem) { echo '<div class="blog-thumb-inner">Ψ</div>'; }
              
              echo '  </div>';
              echo '  <div class="blog-tag">'.htmlspecialchars($categoria).'</div>';
              echo '  <h3 class="blog-title">';
              // A classe stretched-link faz o card todo ficar clicável
              echo '    <a href="template_post.php?id='.$p['id'].'" class="text-decoration-none text-reset stretched-link">'.htmlspecialchars($p['titulo']).'</a>';
              echo '  </h3>';
              echo '  <div class="blog-meta">Publicado em '.$dataFmt.'</div>';
              echo '</div>';
              
          } else {
              // Renderiza o POST FANTASMA (Para não quebrar a tela)
              echo '<div class="blog-card reveal" style="transition-delay:'.$delay.'s; border: 2px dashed rgba(201,168,76,.4); background: transparent; box-shadow: none;">';
              echo '  <div class="blog-thumb" style="background: rgba(201,168,76,.05); display: flex; align-items: center; justify-content: center;">';
              echo '    <svg viewBox="0 0 24 24" width="40" height="40" stroke="rgba(201,168,76,.5)" stroke-width="1" fill="none"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>';
              echo '  </div>';
              echo '  <div class="blog-tag" style="background: rgba(201,168,76,.1); color: transparent; width: 100px; height: 22px; margin-bottom: 15px;"></div>';
              echo '  <h3 class="blog-title" style="color: rgba(201,168,76,.6); font-size: 1.2rem;">Espaço disponível</h3>';
              echo '  <div class="blog-meta" style="color: rgba(201,168,76,.5);">Aguardando publicação</div>';
              echo '</div>';
          }
      }
      ?>
      </div>
    </div>
  </section>

  <section id="contato">
    <div class="contato-content">
      <div class="contato-info reveal">
        <div class="section-eyebrow"><span data-lang="pt">Fale comigo</span><span data-lang="en">Get in touch</span>
        </div>
        <h2 class="section-title"><span data-lang="pt">Agende sua <em>consulta</em></span><span data-lang="en">Book your
            <em>appointment</em></span></h2>
        <p class="section-body"><span data-lang="pt">Estou disponível para atendimentos presenciais em Ribeirão Preto e
            online para todo o Brasil e mundo.</span><span data-lang="en">Available for in-person sessions in Ribeirão
            Preto and online worldwide.</span></p>
        <div class="contact-items">
          <div class="contact-item">
            <div class="contact-item-icon">
              <svg viewBox="0 0 24 24">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                <circle cx="12" cy="10" r="3" />
              </svg>
            </div>
            <div>
              <div class="contact-item-label"><span data-lang="pt">Endereço</span><span data-lang="en">Address</span>
              </div>
              <div class="contact-item-value"><span data-lang="pt">Alto da Boa Vista, Ribeirão Preto – SP</span><span
                  data-lang="en">Alto da Boa Vista, Ribeirão Preto – SP, Brazil</span></div>
            </div>
          </div>
          <div class="contact-item">
            <div class="contact-item-icon">
              <svg viewBox="0 0 24 24">
                <rect x="5" y="2" width="14" height="20" rx="2" ry="2" />
                <line x1="12" y1="18" x2="12.01" y2="18" />
              </svg>
            </div>
            <div>
              <div class="contact-item-label"><span data-lang="pt">WhatsApp</span>
              </div>
              <div class="contact-item-value"><a
                  href="https://wa.me/5516991286116?text=Olá%2C%20gostaria%20de%20agendar%20uma%20consulta"
                  target="_blank" style="color:rgba(245,240,232,.8);text-decoration:none">(16) 99128-6116</a></div>
            </div>
          </div>
          <div class="contact-item mt-2">
            <a class="btn btn-primary"
              href="https://www.doctoralia.com.br/daniel-lataro-de-robbio/psicologo/ribeirao-preto"><span
                data-lang="pt">Mais detalhes</span><span data-lang="en">More
                Details</span></a>
          </div>
        </div>
      </div>
      <div class="background-doctoralia">
        <div class="agenda-consulta">
          <a id="zl-url" class="zl-url"
            href="https://www.doctoralia.com.br/daniel-lataro-de-robbio/psicologo/ribeirao-preto" rel="nofollow"
            data-zlw-doctor="daniel-lataro-de-robbio" data-zlw-type="big_with_calendar" data-zlw-opinion="false"
            data-zlw-hide-branding="true" data-zlw-saas-only="true"
            data-zlw-a11y-title="Widget de marcação de consultas médicas">Marque uma consulta</a>
          <script>
          ! function($_x, _s, id) {
            var js, fjs = $_x.getElementsByTagName(_s)[0];
            if (!$_x.getElementById(id)) {
              js = $_x.createElement(_s);
              js.id = id;
              js.src = "//platform.docplanner.com/js/widget.js";
              fjs.parentNode.insertBefore(js, fjs);
            }
          }(document, "script", "zl-widget-s");
          </script>
        </div>
      </div>
    </div>
  </section>

  <div class="map-section">
    <div id="map-local" class=""></div>
    <span style="font-size: 1rem;font-family:'DM Sans',sans-serif"><span data-lang="pt">R. José Borges da Costa, 785 -
        Sala 11 - Alto da Boa Vista, Ribeirão Preto - SP, 14025-660</span><span data-lang="en">R. José Borges da Costa,
        785 - Sala 11 - Alto da Boa Vista, Ribeirão Preto - SP, 14025-660</span></span>
  </div>

  <section id="instagram">
    <div class="section-eyebrow" style="display:flex;margin-bottom:.5rem;justify-content:center;">Instagram</div>
    <h2 class="section-title" style="text-align:center"><span data-lang="pt">Conteúdo nas <em>redes</em></span><span
        data-lang="en">Content on <em>social</em></span></h2>
    <div class="instagram-grid reveal">
      <div class="insta-placeholder">
        <img src="src/img/social_media/post1.png" alt="Imagem post instagram">
      </div>
      <div class="insta-placeholder">
        <img src="src/img/social_media/post2.png" alt="Imagem post instagram">
      </div>
      <div class="insta-placeholder">
        <img src="src/img/social_media/post3.png" alt="Imagem post instagram">
      </div>
      <div class="insta-placeholder">
        <img src="src/img/social_media/post4.png" alt="Imagem post instagram">
      </div>
    </div>
    <p style="margin-top:1.5rem;font-size:.82rem;color:var(--text-light)"><span data-lang="pt">Siga @drdaniel para mais
        conteúdos</span><span data-lang="en">Follow @drdaniel for more content</span></p>
  </section>

  <?php 
  include "./includes/footer.php";
  ?>
</body>

<a class="whatsapp-float" href="https://wa.me/5516991286116?text=Olá%2C%20gostaria%20de%20agendar%20uma%20consulta"
  target="_blank" title="WhatsApp">
  <svg viewBox="0 0 24 24">
    <path
      d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
  </svg>
</a>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="public/js/mapa.js"></script>
<script src="public/js/script.js"></script>
</body>

</html>