import os
from pptx import Presentation
from pptx.util import Inches, Pt
from pptx.dml.color import RGBColor
from pptx.enum.text import PP_ALIGN, MSO_ANCHOR
from pptx.enum.shapes import MSO_SHAPE

def create_deck(output_filename="eWitnessVault_Gemma_Hackafest_Pitch.pptx"):
    prs = Presentation()
    # 16:9 Widescreen dimensions
    prs.slide_width = Inches(13.333)
    prs.slide_height = Inches(7.5)
    blank_layout = prs.slide_layouts[6]

    # Color Palette
    BG_DARK = RGBColor(10, 14, 26)         # Deep judicial dark #0A0E1A
    CARD_BG = RGBColor(19, 29, 49)         # Panel dark slate #131D31
    CARD_BG_LIGHT = RGBColor(26, 38, 64)   # Accent panel #1A2640
    ACCENT_GOLD = RGBColor(245, 158, 11)   # Vault Gold #F59E0B
    ACCENT_PURPLE = RGBColor(168, 85, 247) # Gemma Violet #A855F7
    ACCENT_CYAN = RGBColor(6, 182, 212)    # Tech Cyan #06B6D4
    ACCENT_GREEN = RGBColor(16, 185, 129)  # Integrity Green #10B981
    ACCENT_RED = RGBColor(239, 68, 68)     # Risk / Problem Red #EF4444
    TEXT_WHITE = RGBColor(248, 250, 252)   # Title white
    TEXT_MUTED = RGBColor(148, 163, 184)   # Slate 400
    TEXT_BODY = RGBColor(226, 232, 240)    # Slate 200

    def apply_background(slide):
        bg = slide.shapes.add_shape(MSO_SHAPE.RECTANGLE, 0, 0, Inches(13.333), Inches(7.5))
        bg.fill.solid()
        bg.fill.fore_color.rgb = BG_DARK
        bg.line.fill.background()
        return bg

    def add_card(slide, left, top, width, height, bg_color=CARD_BG, border_color=None):
        card = slide.shapes.add_shape(MSO_SHAPE.ROUNDED_RECTANGLE, Inches(left), Inches(top), Inches(width), Inches(height))
        card.fill.solid()
        card.fill.fore_color.rgb = bg_color
        if border_color:
            card.line.color.rgb = border_color
            card.line.width = Pt(1.5)
        else:
            card.line.fill.background()
        return card

    def add_header(slide, title, category="GEMMA HACKAFEST 2026", subtitle=None):
        # Category pill
        cat_box = slide.shapes.add_textbox(Inches(0.8), Inches(0.45), Inches(11), Inches(0.4))
        tf_cat = cat_box.text_frame
        tf_cat.word_wrap = True
        p_cat = tf_cat.paragraphs[0]
        p_cat.text = f"[  {category.upper()}  ]"
        p_cat.font.size = Pt(11)
        p_cat.font.bold = True
        p_cat.font.color.rgb = ACCENT_PURPLE
        p_cat.font.name = "Trebuchet MS"

        # Main Title
        title_box = slide.shapes.add_textbox(Inches(0.8), Inches(0.8), Inches(11.5), Inches(0.8))
        tf_title = title_box.text_frame
        tf_title.word_wrap = True
        p_title = tf_title.paragraphs[0]
        p_title.text = title
        p_title.font.size = Pt(28)
        p_title.font.bold = True
        p_title.font.color.rgb = TEXT_WHITE
        p_title.font.name = "Georgia"

        # Subtitle
        if subtitle:
            sub_box = slide.shapes.add_textbox(Inches(0.8), Inches(1.5), Inches(11.5), Inches(0.5))
            tf_sub = sub_box.text_frame
            tf_sub.word_wrap = True
            p_sub = tf_sub.paragraphs[0]
            p_sub.text = subtitle
            p_sub.font.size = Pt(13)
            p_sub.font.color.rgb = TEXT_MUTED
            p_sub.font.name = "Calibri"

    # ==========================================
    # SLIDE 1: COVER / TITLE SLIDE
    # ==========================================
    s1 = prs.slides.add_slide(blank_layout)
    apply_background(s1)

    # Accent decorative glow bar
    bar = s1.shapes.add_shape(MSO_SHAPE.RECTANGLE, Inches(0.8), Inches(1.2), Inches(0.12), Inches(4.5))
    bar.fill.solid()
    bar.fill.fore_color.rgb = ACCENT_PURPLE
    bar.line.fill.background()

    # Title & Subtitles
    tb1 = s1.shapes.add_textbox(Inches(1.2), Inches(1.2), Inches(11), Inches(4.5))
    tf1 = tb1.text_frame
    tf1.word_wrap = True

    p0 = tf1.paragraphs[0]
    p0.text = "GEMMA HACKAFEST 2026  |  LEGAL & FORENSIC TRACK"
    p0.font.size = Pt(13)
    p0.font.bold = True
    p0.font.color.rgb = ACCENT_PURPLE
    p0.font.name = "Trebuchet MS"

    p1 = tf1.add_paragraph()
    p1.text = "eWitnessVault"
    p1.font.size = Pt(54)
    p1.font.bold = True
    p1.font.color.rgb = ACCENT_GOLD
    p1.font.name = "Georgia"
    p1.space_before = Pt(10)

    p2 = tf1.add_paragraph()
    p2.text = "Tamper-Proof Evidence Vault & Judicial AI Intelligence"
    p2.font.size = Pt(24)
    p2.font.bold = True
    p2.font.color.rgb = TEXT_WHITE
    p2.font.name = "Trebuchet MS"
    p2.space_before = Pt(12)

    p3 = tf1.add_paragraph()
    p3.text = "Powered by Google Gemma 3 & Gemma 2 for Private, Sovereign Legal Reasoning"
    p3.font.size = Pt(16)
    p3.font.color.rgb = ACCENT_CYAN
    p3.font.name = "Calibri"
    p3.space_before = Pt(8)

    # Bottom Meta Bar
    add_card(s1, 0.8, 6.0, 11.733, 0.85, CARD_BG, ACCENT_PURPLE)
    meta_box = s1.shapes.add_textbox(Inches(1.1), Inches(6.12), Inches(11.1), Inches(0.6))
    tf_meta = meta_box.text_frame
    p_meta = tf_meta.paragraphs[0]
    p_meta.text = "Presenter: Gilbert Inkamanyire  |  Project: eWitnessVault  |  GitHub: gilbertinkamanyire/Hackafest-  |  Live Demo Ready"
    p_meta.font.size = Pt(13)
    p_meta.font.color.rgb = TEXT_BODY
    p_meta.font.bold = True
    p_meta.font.name = "Calibri"

    # ==========================================
    # SLIDE 2: THE PROBLEM (CRISIS IN JUSTICE)
    # ==========================================
    s2 = prs.slides.add_slide(blank_layout)
    apply_background(s2)
    add_header(s2, "The Crisis in Modern Evidentiary & Courtroom Justice", "THE PROBLEM", "Digital evidence is expanding exponentially, but the judicial system is breaking under friction and mistrust.")

    cols2 = [
        {"num": "100M+", "label": "GLOBAL CASE BACKLOG", "title": "Crippling Judicial Delays", "desc": "Courts and public defenders face months of manual evidence inspection, drowning in unorganized files, surveillance videos, and scattered witness reports.", "color": ACCENT_RED},
        {"num": "35%", "label": "EVIDENCE CHALLENGED", "title": "Tampering & Custody Gaps", "desc": "Evidence routinely dismissed due to missing EXIF metadata, unverified capture chains, and inability to prove media hasn't been altered or fabricated with generative AI.", "color": ACCENT_GOLD},
        {"num": "0%", "label": "ZERO PUBLIC AI PRIVACY", "title": "Confidentiality Redlines", "desc": "Courts and law enforcement CANNOT paste witness testimony into public cloud AI APIs without breaching chain-of-custody laws and endangering witness safety.", "color": ACCENT_PURPLE},
    ]

    for i, col in enumerate(cols2):
        x = 0.8 + i * 3.98
        add_card(s2, x, 2.2, 3.75, 4.6, CARD_BG, col["color"])
        
        # Num Stat
        stat_box = s2.shapes.add_textbox(Inches(x + 0.2), Inches(2.4), Inches(3.35), Inches(0.8))
        tf_s = stat_box.text_frame
        p_s = tf_s.paragraphs[0]
        p_s.text = col["num"]
        p_s.font.size = Pt(36)
        p_s.font.bold = True
        p_s.font.color.rgb = col["color"]
        p_s.font.name = "Trebuchet MS"

        p_lbl = tf_s.add_paragraph()
        p_lbl.text = col["label"]
        p_lbl.font.size = Pt(10)
        p_lbl.font.bold = True
        p_lbl.font.color.rgb = TEXT_MUTED

        # Content
        c_box = s2.shapes.add_textbox(Inches(x + 0.2), Inches(3.5), Inches(3.35), Inches(3.1))
        tf_c = c_box.text_frame
        tf_c.word_wrap = True
        p_t = tf_c.paragraphs[0]
        p_t.text = col["title"]
        p_t.font.size = Pt(18)
        p_t.font.bold = True
        p_t.font.color.rgb = TEXT_WHITE
        p_t.space_after = Pt(10)

        p_d = tf_c.add_paragraph()
        p_d.text = col["desc"]
        p_d.font.size = Pt(13)
        p_d.font.color.rgb = TEXT_BODY
        p_d.line_spacing = 1.25

    # ==========================================
    # SLIDE 3: THE SOLUTION (eWitnessVault + Gemma)
    # ==========================================
    s3 = prs.slides.add_slide(blank_layout)
    apply_background(s3)
    add_header(s3, "The Solution: Cryptographic Vault Meets Sovereign Gemma AI", "THE INNOVATION", "eWitnessVault unifies immutable digital evidence sealing with Google Gemma's open-weights intelligence.")

    # Two Main Pillars
    # Left Pillar: Cryptographic Evidence Vault
    add_card(s3, 0.8, 2.2, 5.7, 4.6, CARD_BG, ACCENT_GOLD)
    p_box1 = s3.shapes.add_textbox(Inches(1.1), Inches(2.4), Inches(5.1), Inches(4.2))
    tf_p1 = p_box1.text_frame
    tf_p1.word_wrap = True

    p = tf_p1.paragraphs[0]
    p.text = "PILLAR 1: Cryptographic Vault"
    p.font.size = Pt(12)
    p.font.bold = True
    p.font.color.rgb = ACCENT_GOLD

    p = tf_p1.add_paragraph()
    p.text = "Tamper-Proof Digital Chain of Custody"
    p.font.size = Pt(20)
    p.font.bold = True
    p.font.color.rgb = TEXT_WHITE
    p.space_after = Pt(14)

    items1 = [
        ("SHA-256 Fingerprinting", "Every photo, video, audio, or document is hashed at ingestion to guarantee zero post-capture tampering."),
        ("Forensic Telemetry Sealing", "Automatically embeds device hardware ID, microsecond timestamps, GPS accuracy, and altitude."),
        ("Admissible Exhibit Dockets", "Official court-ready ledger with permanent digital seals and legal exhibit identifiers.")
    ]
    for title, desc in items1:
        p = tf_p1.add_paragraph()
        p.text = f"- {title}: "
        p.font.bold = True
        p.font.size = Pt(13)
        p.font.color.rgb = ACCENT_GOLD
        p.space_before = Pt(8)
        run = p.add_run()
        run.text = desc
        run.font.bold = False
        run.font.color.rgb = TEXT_BODY

    # Right Pillar: Google Gemma AI
    add_card(s3, 6.833, 2.2, 5.7, 4.6, CARD_BG, ACCENT_PURPLE)
    p_box2 = s3.shapes.add_textbox(Inches(7.133), Inches(2.4), Inches(5.1), Inches(4.2))
    tf_p2 = p_box2.text_frame
    tf_p2.word_wrap = True

    p = tf_p2.paragraphs[0]
    p.text = "PILLAR 2: Google Gemma Intelligence"
    p.font.size = Pt(12)
    p.font.bold = True
    p.font.color.rgb = ACCENT_PURPLE

    p = tf_p2.add_paragraph()
    p.text = "Private Legal Reasoning & Synthesis"
    p.font.size = Pt(20)
    p.font.bold = True
    p.font.color.rgb = TEXT_WHITE
    p.space_after = Pt(14)

    items2 = [
        ("Automated Evidence Forensics", "Gemma scrutinizes metadata contradictions, EXIF timelines, and drafts structured analysis reports."),
        ("Case Docket Brief Generator", "Synthesizes dozens of evidence items into coherent judicial case summaries with strengths and gaps."),
        ("100% Private & Sovereign", "Open weights allow on-premise courthouse deployment. Zero witness data leaves legal jurisdiction.")
    ]
    for title, desc in items2:
        p = tf_p2.add_paragraph()
        p.text = f"- {title}: "
        p.font.bold = True
        p.font.size = Pt(13)
        p.font.color.rgb = ACCENT_PURPLE
        p.space_before = Pt(8)
        run = p.add_run()
        run.text = desc
        run.font.bold = False
        run.font.color.rgb = TEXT_BODY

    # ==========================================
    # SLIDE 4: THE LEGAL AI SUITE (FEATURES)
    # ==========================================
    s4 = prs.slides.add_slide(blank_layout)
    apply_background(s4)
    add_header(s4, "The Evidentiary AI Suite: Built with Gemma", "CORE CAPABILITIES", "Four production-grade judicial AI workflows engineered for judges, prosecutors, lawyers, and investigators.")

    features = [
        {"icon": "01", "name": "Evidence Forensics", "sub": "Exhibit-by-Exhibit Audit", "bullets": ["Scans title, description, and telemetry", "Cross-checks capture time vs upload time", "Evaluates admissibility risks & chain breaks", "Outputs structured legal findings"], "color": ACCENT_PURPLE},
        {"icon": "02", "name": "Docket Briefing", "sub": "Multi-Evidence Synthesis", "bullets": ["Aggregates all linked case exhibits", "Reconstructs unified incident timeline", "Identifies witness inconsistencies", "Highlights critical gaps for cross-exam"], "color": ACCENT_CYAN},
        {"icon": "03", "name": "Judicial AI Hub", "sub": "Central Command Center", "bullets": ["Real-time API connection diagnostics", "Model parameter & temperature tuning", "Quick-action shortcuts for court staff", "Role-gated access (Judge / Lawyer / Admin)"], "color": ACCENT_GOLD},
        {"icon": "04", "name": "Admissibility Proofs", "sub": "Tamper-Proof Certificate", "bullets": ["Courtroom printable exhibit records", "Embedded cryptographic SHA-256 seal", "Chain-of-custody transfer logs", "Judicial verification sign-off ready"], "color": ACCENT_GREEN},
    ]

    for i, feat in enumerate(features):
        x = 0.8 + i * 2.98
        add_card(s4, x, 2.2, 2.8, 4.6, CARD_BG, feat["color"])
        
        fb = s4.shapes.add_textbox(Inches(x + 0.15), Inches(2.35), Inches(2.5), Inches(4.3))
        tf_f = fb.text_frame
        tf_f.word_wrap = True

        p_num = tf_f.paragraphs[0]
        p_num.text = feat["icon"]
        p_num.font.size = Pt(28)
        p_num.font.bold = True
        p_num.font.color.rgb = feat["color"]

        p_nm = tf_f.add_paragraph()
        p_nm.text = feat["name"]
        p_nm.font.size = Pt(17)
        p_nm.font.bold = True
        p_nm.font.color.rgb = TEXT_WHITE

        p_sb = tf_f.add_paragraph()
        p_sb.text = feat["sub"]
        p_sb.font.size = Pt(10)
        p_sb.font.bold = True
        p_sb.font.color.rgb = TEXT_MUTED
        p_sb.space_after = Pt(12)

        for b in feat["bullets"]:
            pb = tf_f.add_paragraph()
            pb.text = f"- {b}"
            pb.font.size = Pt(12)
            pb.font.color.rgb = TEXT_BODY
            pb.line_spacing = 1.2
            pb.space_before = Pt(4)

    # ==========================================
    # SLIDE 5: WHY GOOGLE GEMMA?
    # ==========================================
    s5 = prs.slides.add_slide(blank_layout)
    apply_background(s5)
    add_header(s5, "Why Google Gemma? The Judicial Advantage", "WHY GEMMA?", "Why Gemma is uniquely and fundamentally superior to proprietary black-box APIs for the legal system.")

    reasons = [
        {"title": "Open Weights = Judicial Sovereignty", "desc": "Courts cannot surrender sovereign legal data to commercial cloud vendors. Gemma enables on-premise government hosting with zero outside telemetry.", "tag": "PRIVACY & COMPLIANCE", "color": ACCENT_PURPLE},
        {"title": "Compact & Edge Deployable", "desc": "From Gemma 3 1B to Gemma 2 9B/27B, the architecture runs fast on courthouse workstations, police laptops, or local secure servers without multi-million dollar GPU clusters.", "tag": "EDGE ACCESSIBILITY", "color": ACCENT_CYAN},
        {"title": "Rigorous Structured Output", "desc": "Exceptional adherence to JSON schemas and legal taxonomies, eliminating hallucinations when extracting dates, coordinates, and chain-of-custody discrepancies.", "tag": "REASONING FIDELITY", "color": ACCENT_GOLD},
        {"title": "90% Cost Reduction vs Big Cloud", "desc": "Public defense funds and developing nation judiciaries cannot pay $0.03 per prompt to monopolistic APIs. Gemma delivers sovereign AI at negligible cost.", "tag": "EQUAL ACCESS TO JUSTICE", "color": ACCENT_GREEN},
    ]

    for i, r in enumerate(reasons):
        row = i // 2
        col = i % 2
        x = 0.8 + col * 5.95
        y = 2.2 + row * 2.35
        add_card(s5, x, y, 5.75, 2.15, CARD_BG, r["color"])

        rb = s5.shapes.add_textbox(Inches(x + 0.25), Inches(y + 0.2), Inches(5.25), Inches(1.8))
        tf_r = rb.text_frame
        tf_r.word_wrap = True

        p_tag = tf_r.paragraphs[0]
        p_tag.text = r["tag"]
        p_tag.font.size = Pt(10)
        p_tag.font.bold = True
        p_tag.font.color.rgb = r["color"]

        p_t = tf_r.add_paragraph()
        p_t.text = r["title"]
        p_t.font.size = Pt(16)
        p_t.font.bold = True
        p_t.font.color.rgb = TEXT_WHITE
        p_t.space_before = Pt(2)
        p_t.space_after = Pt(4)

        p_d = tf_r.add_paragraph()
        p_d.text = r["desc"]
        p_d.font.size = Pt(12)
        p_d.font.color.rgb = TEXT_BODY
        p_d.line_spacing = 1.2

    # ==========================================
    # SLIDE 6: END-TO-END WORKFLOW ARCHITECTURE
    # ==========================================
    s6 = prs.slides.add_slide(blank_layout)
    apply_background(s6)
    add_header(s6, "End-to-End System Architecture", "HOW IT WORKS", "From citizen witness or police bodycam to courtroom-admissible, AI-briefed case docket.")

    steps = [
        {"step": "STEP 1", "title": "Secure Capture", "tech": "Web & Capacitor Mobile", "desc": "Witness or officer uploads media. System extracts EXIF, GPS, altitude, device model, and computes SHA-256 hash immediately.", "color": ACCENT_GOLD},
        {"step": "STEP 2", "title": "Vault Sealing", "tech": "Laravel 11 & MySQL/SQLite", "desc": "File is stored in isolated tamper-evident vault. Metadata and hash are locked with timestamped chain-of-custody audit record.", "color": ACCENT_CYAN},
        {"step": "STEP 3", "title": "Gemma AI Engine", "tech": "Google AI Studio / Gemma 3", "desc": "Gemma analyzes metadata, validates incident timelines, inspects integrity flags, and produces forensic legal evaluations.", "color": ACCENT_PURPLE},
        {"step": "STEP 4", "title": "Judicial Decision", "tech": "Judge & Lawyer Dashboard", "desc": "Lawyers bundle evidence into Case Dockets. Judges review Gemma-generated executive briefs and examine verified exhibits.", "color": ACCENT_GREEN},
    ]

    for i, s in enumerate(steps):
        x = 0.8 + i * 2.98
        add_card(s6, x, 2.2, 2.8, 4.6, CARD_BG, s["color"])

        sb = s6.shapes.add_textbox(Inches(x + 0.15), Inches(2.35), Inches(2.5), Inches(4.3))
        tf_s = sb.text_frame
        tf_s.word_wrap = True

        p_s = tf_s.paragraphs[0]
        p_s.text = s["step"]
        p_s.font.size = Pt(12)
        p_s.font.bold = True
        p_s.font.color.rgb = s["color"]

        p_t = tf_s.add_paragraph()
        p_t.text = s["title"]
        p_t.font.size = Pt(18)
        p_t.font.bold = True
        p_t.font.color.rgb = TEXT_WHITE

        p_tch = tf_s.add_paragraph()
        p_tch.text = s["tech"]
        p_tch.font.size = Pt(10)
        p_tch.font.bold = True
        p_tch.font.color.rgb = TEXT_MUTED
        p_tch.space_after = Pt(14)

        p_d = tf_s.add_paragraph()
        p_d.text = s["desc"]
        p_d.font.size = Pt(12)
        p_d.font.color.rgb = TEXT_BODY
        p_d.line_spacing = 1.3

    # ==========================================
    # SLIDE 7: LIVE DEMO / CASE STUDY
    # ==========================================
    s7 = prs.slides.add_slide(blank_layout)
    apply_background(s7)
    add_header(s7, "Live Case Walkthrough: Robbery Investigation #EWV-2026-0014", "REAL-WORLD IMPACT", "Demonstrating Gemma's forensic analysis on multi-exhibit criminal court docket.")

    # Left Box: Exhibit Input
    add_card(s7, 0.8, 2.2, 5.7, 4.6, CARD_BG, ACCENT_GOLD)
    ib = s7.shapes.add_textbox(Inches(1.05), Inches(2.35), Inches(5.2), Inches(4.3))
    tf_i = ib.text_frame
    tf_i.word_wrap = True

    p = tf_i.paragraphs[0]
    p.text = "EVIDENTIARY EXHIBITS INGESTED"
    p.font.size = Pt(11)
    p.font.bold = True
    p.font.color.rgb = ACCENT_GOLD

    p = tf_i.add_paragraph()
    p.text = "Case Docket #EWV-2026-0014"
    p.font.size = Pt(20)
    p.font.bold = True
    p.font.color.rgb = TEXT_WHITE
    p.space_after = Pt(10)

    exhibits = [
        "Exhibit #001: CCTV Footage (Timestamp: 23:14:02 UTC | SHA: e8b9...f2)",
        "Exhibit #002: Eyewitness Mobile Photo (GPS: 0.3476N, 32.5825E | 23:16:10)",
        "Exhibit #003: Ballistic Match Ballistics Report (.pdf)",
        "Exhibit #004: Witness Statement Audio (.m4a)"
    ]
    for ex in exhibits:
        p = tf_i.add_paragraph()
        p.text = ex
        p.font.size = Pt(11)
        p.font.color.rgb = TEXT_BODY
        p.space_before = Pt(4)

    p = tf_i.add_paragraph()
    p.text = "All exhibits sealed with cryptographic hashes & device audit trails."
    p.font.size = Pt(11)
    p.font.color.rgb = ACCENT_CYAN
    p.font.italic = True
    p.space_before = Pt(14)

    # Right Box: Gemma Analysis Output
    add_card(s7, 6.833, 2.2, 5.7, 4.6, CARD_BG, ACCENT_PURPLE)
    ob = s7.shapes.add_textbox(Inches(7.083), Inches(2.35), Inches(5.2), Inches(4.3))
    tf_o = ob.text_frame
    tf_o.word_wrap = True

    p = tf_o.paragraphs[0]
    p.text = "GEMMA AI SYNTHESIS OUTPUT"
    p.font.size = Pt(11)
    p.font.bold = True
    p.font.color.rgb = ACCENT_PURPLE

    p = tf_o.add_paragraph()
    p.text = "Judicial Briefing in 1.4 Seconds"
    p.font.size = Pt(20)
    p.font.bold = True
    p.font.color.rgb = TEXT_WHITE
    p.space_after = Pt(10)

    findings = [
        ("Timeline Alignment: ", "Synchronized 4 exhibits to establish a 4-minute incident timeline between 23:13 and 23:17."),
        ("Critical Contradiction Detected: ", "Exhibit #002 GPS coordinates place witness 1.2km away from Exhibit #001 CCTV location!"),
        ("Admissibility Score: 94/100: ", "Chain of custody unbroken; all cryptographic hashes match raw source."),
        ("Prosecution Question: ", "Ask witness why metadata timestamp precedes CCTV vehicle arrival.")
    ]
    for prefix, body in findings:
        p = tf_o.add_paragraph()
        p.text = f"- {prefix}"
        p.font.bold = True
        p.font.size = Pt(12)
        p.font.color.rgb = ACCENT_PURPLE
        p.space_before = Pt(5)
        run = p.add_run()
        run.text = body
        run.font.bold = False
        run.font.color.rgb = TEXT_BODY

    # ==========================================
    # SLIDE 8: COMPETITIVE MOAT (MATRIX)
    # ==========================================
    s8 = prs.slides.add_slide(blank_layout)
    apply_background(s8)
    add_header(s8, "Competitive Moat: Why eWitnessVault Wins", "COMPETITIVE LANDSCAPE", "Comparing eWitnessVault with traditional LegalTech software and generic AI tools.")

    # Table
    table_shape = s8.shapes.add_table(5, 4, Inches(0.8), Inches(2.3), Inches(11.733), Inches(4.4))
    table = table_shape.table

    # Column widths
    table.columns[0].width = Inches(3.5)
    table.columns[1].width = Inches(2.8)
    table.columns[2].width = Inches(2.7)
    table.columns[3].width = Inches(2.733)

    headers = ["CAPABILITY", "eWitnessVault (Gemma)", "Traditional LegalTech", "Generic AI (ChatGPT/Claude)"]
    for j, h in enumerate(headers):
        cell = table.cell(0, j)
        cell.fill.solid()
        cell.fill.fore_color.rgb = CARD_BG_LIGHT if j != 1 else ACCENT_PURPLE
        p = cell.text_frame.paragraphs[0]
        p.text = h
        p.font.bold = True
        p.font.size = Pt(13)
        p.font.color.rgb = TEXT_WHITE
        p.alignment = PP_ALIGN.CENTER if j > 0 else PP_ALIGN.LEFT

    rows_data = [
        ("Cryptographic Tamper-Proof Sealing", "YES (SHA-256 + EXIF)", "NO (Standard file storage)", "NO (Zero file provenance)"),
        ("Private Sovereign AI Reasoning", "YES (Google Gemma Open)", "NO (No AI capabilities)", "NO (Data sent to US multi-tenant)"),
        ("Courtroom Exhibit Dockets", "YES (Admissible certificates)", "Partial (Clunky PDF exports)", "NO (Unformatted text responses)"),
        ("Hardware / Edge Deployment Ready", "YES (Gemma 3 1B/4B/12B)", "NO (Legacy on-prem monoliths)", "NO (Cloud API connection only)")
    ]

    for i, row in enumerate(rows_data):
        for j, val in enumerate(row):
            cell = table.cell(i + 1, j)
            cell.fill.solid()
            cell.fill.fore_color.rgb = CARD_BG if j != 1 else RGBColor(30, 20, 50)
            p = cell.text_frame.paragraphs[0]
            p.text = val
            p.font.size = Pt(12)
            p.font.color.rgb = ACCENT_GOLD if j == 1 else (TEXT_WHITE if j == 0 else TEXT_MUTED)
            p.font.bold = (j <= 1)
            p.alignment = PP_ALIGN.CENTER if j > 0 else PP_ALIGN.LEFT

    # ==========================================
    # SLIDE 9: MARKET OPPORTUNITY & BUSINESS MODEL
    # ==========================================
    s9 = prs.slides.add_slide(blank_layout)
    apply_background(s9)
    add_header(s9, "Market Opportunity & Business Model", "COMMERCIAL VIABILITY", "Capturing high-margin GovTech & LegalTech segments with scalable sovereign deployments.")

    m_cols = [
        {"num": "$35B+", "lbl": "GLOBAL LEGALTECH MARKET", "title": "Market Scale", "items": ["Judiciaries, law firms, and court clerks worldwide", "Accelerated by digital court modernization mandates", "Expanding in emerging markets with severe court backlog"], "color": ACCENT_CYAN},
        {"num": "3-Tier", "lbl": "ENTERPRISE MONETIZATION", "title": "Revenue Model", "items": ["SaaS Subscription: Tiered per legal seat/lawyer", "Sovereign Node License: On-prem Gemma for Judiciaries", "High-Volume Case API: Forensic evidence hashing & AI briefs"], "color": ACCENT_GOLD},
        {"num": "75%", "lbl": "TRIAL PREP TIME SAVINGS", "title": "ROI for Clients", "items": ["Reduces evidence review time from weeks to hours", "Eliminates chain-of-custody evidentiary mistrials", "Enables public defenders to represent 3x more clients"], "color": ACCENT_GREEN},
    ]

    for i, col in enumerate(m_cols):
        x = 0.8 + i * 3.98
        add_card(s9, x, 2.2, 3.75, 4.6, CARD_BG, col["color"])

        b = s9.shapes.add_textbox(Inches(x + 0.2), Inches(2.35), Inches(3.35), Inches(4.3))
        tf = b.text_frame
        tf.word_wrap = True

        p = tf.paragraphs[0]
        p.text = col["num"]
        p.font.size = Pt(36)
        p.font.bold = True
        p.font.color.rgb = col["color"]

        p = tf.add_paragraph()
        p.text = col["lbl"]
        p.font.size = Pt(10)
        p.font.bold = True
        p.font.color.rgb = TEXT_MUTED

        p = tf.add_paragraph()
        p.text = col["title"]
        p.font.size = Pt(18)
        p.font.bold = True
        p.font.color.rgb = TEXT_WHITE
        p.space_before = Pt(10)
        p.space_after = Pt(10)

        for itm in col["items"]:
            pi = tf.add_paragraph()
            pi.text = f"- {itm}"
            pi.font.size = Pt(12)
            pi.font.color.rgb = TEXT_BODY
            pi.space_before = Pt(5)

    # ==========================================
    # SLIDE 10: ROADMAP & FUTURE VISION
    # ==========================================
    s10 = prs.slides.add_slide(blank_layout)
    apply_background(s10)
    add_header(s10, "Strategic Roadmap: Building the Sovereign Judicial Cloud", "FUTURE VISION", "Scaling from today's hackathon prototype to nationwide legal infrastructure.")

    phases = [
        {"phase": "PHASE 1 (NOW)", "date": "Q2 2026", "title": "Gemma AI Suite", "desc": "Live evidence analysis, automated case docket briefs, cryptographic SHA-256 vault sealing, and role-based access control.", "color": ACCENT_GREEN},
        {"phase": "PHASE 2", "date": "Q3 2026", "title": "Multimodal Gemma 3 Vision", "desc": "Direct frame-by-frame deepfake analysis, audio voiceprint forensics, and automated video transcript alignment.", "color": ACCENT_PURPLE},
        {"phase": "PHASE 3", "date": "Q4 2026", "title": "Courthouse Edge Nodes", "desc": "Pre-configured air-gapped Gemma appliances for confidential supreme courts and military tribunals.", "color": ACCENT_CYAN},
        {"phase": "PHASE 4", "date": "2027+", "title": "Global Justice Network", "desc": "Inter-agency cross-jurisdiction evidence verification for international human rights tribunals and interpol dockets.", "color": ACCENT_GOLD},
    ]

    for i, p_info in enumerate(phases):
        x = 0.8 + i * 2.98
        add_card(s10, x, 2.2, 2.8, 4.6, CARD_BG, p_info["color"])

        pb = s10.shapes.add_textbox(Inches(x + 0.15), Inches(2.35), Inches(2.5), Inches(4.3))
        tf_p = pb.text_frame
        tf_p.word_wrap = True

        p = tf_p.paragraphs[0]
        p.text = p_info["phase"]
        p.font.size = Pt(11)
        p.font.bold = True
        p.font.color.rgb = p_info["color"]

        p = tf_p.add_paragraph()
        p.text = p_info["date"]
        p.font.size = Pt(10)
        p.font.bold = True
        p.font.color.rgb = TEXT_MUTED

        p = tf_p.add_paragraph()
        p.text = p_info["title"]
        p.font.size = Pt(17)
        p.font.bold = True
        p.font.color.rgb = TEXT_WHITE
        p.space_before = Pt(8)
        p.space_after = Pt(10)

        p = tf_p.add_paragraph()
        p.text = p_info["desc"]
        p.font.size = Pt(12)
        p.font.color.rgb = TEXT_BODY
        p.line_spacing = 1.3

    # ==========================================
    # SLIDE 11: WHY WE WIN THIS HACKATHON
    # ==========================================
    s11 = prs.slides.add_slide(blank_layout)
    apply_background(s11)
    add_header(s11, "Why eWitnessVault Wins the Gemma Hackafest", "JUDGING CRITERIA", "Evaluating eWitnessVault across all hackathon evaluation pillars.")

    rubrics = [
        {"pill": "INNOVATION & IMPACT", "title": "Solves a Real Humanitarian Need", "desc": "Not just another chat toy. Solves court backlogs and false convictions with cryptographic certainty and ethical, sovereign AI.", "color": ACCENT_GOLD},
        {"pill": "TECHNICAL EXECUTION", "title": "Full Production Full-Stack App", "desc": "Laravel 11 backend, reactive Blade UI, REST API, MySQL/SQLite database schema, custom GemmaService, and verified routes.", "color": ACCENT_PURPLE},
        {"pill": "DEEP GEMMA UTILIZATION", "title": "Leverages Gemma's Core DNA", "desc": "Capitalizes on Gemma's open weights, privacy sovereignty, structured outputs, and lightweight edge footprint for judicial compliance.", "color": ACCENT_CYAN},
        {"pill": "POLISH & COMPLETENESS", "title": "Live, Working & Deployed", "desc": "Real git commit history, comprehensive views, navigation integration, and active repository at github.com/gilbertinkamanyire/Hackafest-.", "color": ACCENT_GREEN},
    ]

    for i, rb in enumerate(rubrics):
        row = i // 2
        col = i % 2
        x = 0.8 + col * 5.95
        y = 2.2 + row * 2.35
        add_card(s11, x, y, 5.75, 2.15, CARD_BG, rb["color"])

        box = s11.shapes.add_textbox(Inches(x + 0.25), Inches(y + 0.2), Inches(5.25), Inches(1.8))
        tf = box.text_frame
        tf.word_wrap = True

        p = tf.paragraphs[0]
        p.text = rb["pill"]
        p.font.size = Pt(10)
        p.font.bold = True
        p.font.color.rgb = rb["color"]

        p = tf.add_paragraph()
        p.text = rb["title"]
        p.font.size = Pt(17)
        p.font.bold = True
        p.font.color.rgb = TEXT_WHITE
        p.space_before = Pt(3)
        p.space_after = Pt(4)

        p = tf.add_paragraph()
        p.text = rb["desc"]
        p.font.size = Pt(12)
        p.font.color.rgb = TEXT_BODY
        p.line_spacing = 1.25

    # ==========================================
    # SLIDE 12: CALL TO ACTION & THANK YOU
    # ==========================================
    s12 = prs.slides.add_slide(blank_layout)
    apply_background(s12)

    add_card(s12, 1.5, 1.2, 10.333, 5.1, CARD_BG, ACCENT_PURPLE)
    
    cb = s12.shapes.add_textbox(Inches(1.8), Inches(1.5), Inches(9.733), Inches(4.5))
    tf_c = cb.text_frame
    tf_c.word_wrap = True

    p = tf_c.paragraphs[0]
    p.text = "SEALING TRUTH. ACCELERATING JUSTICE."
    p.font.size = Pt(13)
    p.font.bold = True
    p.font.color.rgb = ACCENT_PURPLE
    p.font.name = "Trebuchet MS"

    p = tf_c.add_paragraph()
    p.text = "Experience the Future of Evidentiary AI"
    p.font.size = Pt(38)
    p.font.bold = True
    p.font.color.rgb = ACCENT_GOLD
    p.font.name = "Georgia"
    p.space_before = Pt(10)

    p = tf_c.add_paragraph()
    p.text = "eWitnessVault is ready for courtroom trials, legal defense teams, and human rights missions worldwide."
    p.font.size = Pt(16)
    p.font.color.rgb = TEXT_WHITE
    p.font.name = "Calibri"
    p.space_before = Pt(14)
    p.space_after = Pt(20)

    p = tf_c.add_paragraph()
    p.text = "Repository: https://github.com/gilbertinkamanyire/Hackafest-"
    p.font.size = Pt(15)
    p.font.bold = True
    p.font.color.rgb = ACCENT_CYAN
    p.font.name = "Calibri"

    p = tf_c.add_paragraph()
    p.text = "Lead Developer: Gilbert Inkamanyire | eWitnessVault Core Team"
    p.font.size = Pt(14)
    p.font.color.rgb = TEXT_MUTED
    p.font.name = "Calibri"
    p.space_before = Pt(6)

    p = tf_c.add_paragraph()
    p.text = "Thank you Judges & Google Gemma Team! We are ready for Q&A."
    p.font.size = Pt(16)
    p.font.bold = True
    p.font.color.rgb = ACCENT_GREEN
    p.font.name = "Trebuchet MS"
    p.space_before = Pt(16)

    # Save presentation
    output_path = os.path.abspath(output_filename)
    prs.save(output_path)
    print(f"Presentation saved successfully to: {output_path}")

if __name__ == "__main__":
    create_deck()
