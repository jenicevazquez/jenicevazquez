/****** Object:  Table [dbo].[edocuments]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[edocuments](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[cadenaOriginal] [varchar](250) NULL,
	[errores] [varchar](250) NULL,
	[selloDigital] [varchar](1000) NULL,
	[tipoDocumento] [int] NULL,
	[archivoxml_id] [int] NULL,
	[licencia] [int] NULL,
	[documento] [varchar](50) NULL,
	[archivopdf_id] [int] NULL,
 CONSTRAINT [PK_edocuments] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
