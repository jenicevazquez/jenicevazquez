/****** Object:  Table [dbo].[importadores]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[importadores](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[contribuyente_id] [int] NULL,
	[pedimento_id] [int] NULL,
	[seguros] [decimal](18, 2) NULL,
	[embalajes] [decimal](18, 2) NULL,
	[bultos] [int] NULL,
	[fletes] [decimal](18, 2) NULL,
	[incrementables] [decimal](18, 2) NULL,
	[despacho] [int] NULL,
	[efectivo] [decimal](18, 2) NULL,
	[otros] [decimal](18, 2) NULL,
	[total] [decimal](18, 2) NULL,
	[pais] [varchar](5) NULL,
	[rfc] [varchar](13) NULL,
	[curp] [varchar](18) NULL,
	[razonsocial] [varchar](120) NULL,
	[domicilio_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_importadores2] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
